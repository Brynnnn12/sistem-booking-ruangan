<?php

namespace App\Services;

use App\Models\Booking;
use App\Repositories\BookingRepository;
use App\Repositories\RoomRepository;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function __construct(
        protected BookingRepository $bookingRepository,
        protected RoomRepository $roomRepository
    ) {}

    public function getPaginated(int $perPage = 10, array $filters = [])
    {
        return $this->bookingRepository->paginate($perPage, $filters);
    }

    public function getActiveRooms()
    {
        return $this->roomRepository->getActive();
    }

    public function create(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            // Validasi batasan user (kuota + sesi aktif)
            $this->validateUserLimits(
                $data['user_id'],
                $data['booking_date'],
                $data['start_time'],
                $data['end_time']
            );

            // Validasi ruangan aktif
            if (!$this->roomRepository->isActive($data['room_id'])) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'room_id' => 'Ruangan tidak aktif.',
                ]);
            }

            $this->assertNoOverlap(
                $data['room_id'],
                $data['booking_date'],
                $data['start_time'],
                $data['end_time']
            );

            $data['status'] = Booking::STATUS_PENDING;

            return $this->bookingRepository->create($data);
        });
    }

    public function update(Booking $booking, array $data): bool
    {
        return DB::transaction(function () use ($booking, $data) {
            // Jika booking sudah approved dan sudah dimulai, tidak boleh update
            if ($booking->isApproved() && $booking->booking_date->isToday() && now()->format('H:i:s') >= $booking->start_time) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'booking' => 'Booking yang sudah dimulai tidak dapat diubah.',
                ]);
            }

            // Validasi batasan user HANYA jika tanggal berubah (untuk efisiensi)
            if (array_key_exists('booking_date', $data) && $data['booking_date'] !== $booking->booking_date->format('Y-m-d')) {
                $this->validateUserLimits(
                    $booking->user_id,
                    $data['booking_date'],
                    $data['start_time'] ?? $booking->start_time,
                    $data['end_time'] ?? $booking->end_time,
                    $booking->id  // Exclude ID agar tidak dihitung sendiri
                );
            }

            // Validasi ruangan aktif jika room_id berubah
            if (array_key_exists('room_id', $data) && !$this->roomRepository->isActive($data['room_id'])) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'room_id' => 'Ruangan tidak aktif.',
                ]);
            }

            if ($this->isScheduleChanging($data)) {
                $this->assertNoOverlap(
                    $data['room_id'] ?? $booking->room_id,
                    $data['booking_date'] ?? $booking->booking_date->format('Y-m-d'),
                    $data['start_time'] ?? $booking->start_time,
                    $data['end_time'] ?? $booking->end_time,
                    $booking->id
                );
            }

            return $this->bookingRepository->update($booking, $data);
        });
    }

    public function approve(Booking $booking, int $adminId): bool
    {
        return DB::transaction(function () use ($booking, $adminId) {
            if ($booking->status !== Booking::STATUS_PENDING) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'status' => 'Booking sudah diproses.',
                ]);
            }

            return $this->bookingRepository->approve($booking, $adminId);
        });
    }

    public function reject(Booking $booking, int $adminId): bool
    {
        return DB::transaction(function () use ($booking, $adminId) {
            if ($booking->status !== Booking::STATUS_PENDING) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'status' => 'Booking sudah diproses.',
                ]);
            }

            return $this->bookingRepository->reject($booking, $adminId);
        });
    }

    public function cancel(Booking $booking): bool
    {
        return DB::transaction(function () use ($booking) {
            if (in_array($booking->status, [Booking::STATUS_CANCELLED, Booking::STATUS_REJECTED], true)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'status' => 'Booking sudah dibatalkan atau ditolak.',
                ]);
            }

            // Jika booking sudah dimulai (aktif), tidak boleh cancel
            if ($booking->isApproved() && $booking->booking_date->isToday() && now()->format('H:i:s') >= $booking->start_time) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'status' => 'Booking yang sedang berlangsung tidak dapat dibatalkan.',
                ]);
            }

            return $this->bookingRepository->cancel($booking);
        });
    }

    public function delete(Booking $booking): bool
    {
        return DB::transaction(function () use ($booking) {
            // Jika booking approved dan aktif, tidak boleh delete
            if ($booking->isApproved() && ($booking->booking_date->isFuture() || ($booking->booking_date->isToday() && now()->format('H:i:s') < $booking->end_time))) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'booking' => 'Booking yang aktif atau dijadwalkan di masa depan tidak dapat dihapus.',
                ]);
            }

            return $this->bookingRepository->delete($booking);
        });
    }

    private function assertNoOverlap(int $roomId, string $bookingDate, string $startTime, string $endTime, ?int $excludeId = null): void
    {
        if ($this->bookingRepository->hasOverlap($roomId, $bookingDate, $startTime, $endTime, $excludeId)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'overlap' => 'Waktu booking bertabrakan dengan booking lain di ruangan yang sama.',
            ]);
        }
    }

    private function isScheduleChanging(array $data): bool
    {
        return array_key_exists('room_id', $data)
            || array_key_exists('booking_date', $data)
            || array_key_exists('start_time', $data)
            || array_key_exists('end_time', $data);
    }

    private function validateUserLimits(int $userId, string $bookingDate, string $startTime, string $endTime, ?int $excludeId = null): void
    {
        $currentTime = now()->format('H:i:s');  // Gunakan now() untuk pengecekan akurat
        $today = now()->toDateString();

        // Cek booking tidak di masa lalu
        if ($bookingDate < $today || ($bookingDate === $today && $startTime <= $currentTime)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'booking_date' => 'Tidak dapat booking untuk waktu yang sudah lewat.',
            ]);
        }

        // 1. Cek kuota: Maksimal 2 booking per hari (pending/approved)
        $userBookingCount = $this->bookingRepository->getUserBookingCountForDate($userId, $bookingDate, $excludeId);
        if ($userBookingCount >= 2) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'booking_date' => 'Anda sudah mencapai batas maksimal 2 booking per hari pada tanggal tersebut.',
            ]);
        }

        // 2. Cek sesi aktif: Tidak boleh booking jika sudah ada sesi aktif (approved dan belum selesai) - berlaku untuk semua user
        if ($this->bookingRepository->hasActiveBooking($userId, $currentTime, $today)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'booking' => 'Anda sudah memiliki booking aktif. Tunggu hingga sesi selesai.',
            ]);
        }
    }
}
