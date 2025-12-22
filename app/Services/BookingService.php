<?php

namespace App\Services;

use App\Models\Booking;
use App\Repositories\BookingRepository;

class BookingService
{
    public function __construct(
        protected BookingRepository $bookingRepository
    ) {}

    public function create(array $data): Booking
    {
        $this->assertNoOverlap(
            $data['room_id'],
            $data['start_time'],
            $data['end_time']
        );

        $data['status'] = Booking::STATUS_PENDING;

        return $this->bookingRepository->create($data);
    }

    public function update(Booking $booking, array $data): bool
    {
        if ($this->isScheduleChanging($data)) {
            $this->assertNoOverlap(
                $data['room_id'] ?? $booking->room_id,
                $data['start_time'] ?? $booking->start_time,
                $data['end_time'] ?? $booking->end_time,
                $booking->id
            );
        }

        return $this->bookingRepository->update($booking, $data);
    }

    public function approve(Booking $booking, int $adminId): bool
    {
        if ($booking->status !== Booking::STATUS_PENDING) {
            throw new \DomainException('Booking sudah diproses.');
        }

        return $this->bookingRepository->approve($booking, $adminId);
    }

    public function reject(Booking $booking, int $adminId): bool
    {
        if ($booking->status !== Booking::STATUS_PENDING) {
            throw new \DomainException('Booking sudah diproses.');
        }

        return $this->bookingRepository->reject($booking, $adminId);
    }

    public function cancel(Booking $booking): bool
    {
        if (in_array($booking->status, [Booking::STATUS_CANCELLED, Booking::STATUS_REJECTED], true)) {
            throw new \DomainException('Booking sudah dibatalkan atau ditolak.');
        }

        return $this->bookingRepository->cancel($booking);
    }

    public function delete(Booking $booking): bool
    {
        return $this->bookingRepository->delete($booking);
    }

    private function assertNoOverlap(int $roomId, string $startTime, string $endTime, ?int $excludeId = null): void
    {
        if ($this->bookingRepository->hasOverlap($roomId, $startTime, $endTime, $excludeId)) {
            throw new \DomainException('Ruangan sudah dipesan.');
        }
    }

    private function isScheduleChanging(array $data): bool
    {
        return array_key_exists('room_id', $data)
            || array_key_exists('start_time', $data)
            || array_key_exists('end_time', $data);
    }
}
