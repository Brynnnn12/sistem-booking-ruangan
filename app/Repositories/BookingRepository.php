<?php

namespace App\Repositories;

use App\Models\Booking;

class BookingRepository
{
    public function baseQuery()
    {
        return Booking::with(['room', 'user', 'approvedBy']);
    }

    public function paginate(int $perPage = 10, array $filters = [])
    {
        return $this->baseQuery()
            ->status($filters['status'] ?? null)
            ->forUser($filters['user_id'] ?? null)
            ->forRoom($filters['room_id'] ?? null)
            ->orderByDesc('booking_date')
            ->orderByDesc('start_time')
            ->paginate($perPage);
    }

    public function create(array $data): Booking
    {
        return Booking::create($data);
    }

    public function update(Booking $booking, array $data): bool
    {
        return $booking->update($data);
    }

    public function delete(Booking $booking): bool
    {
        return $booking->delete();
    }

    public function approve(Booking $booking, int $adminId): bool
    {
        return $booking->update([
            'status'      => Booking::STATUS_APPROVED,
            'approved_by' => $adminId,
        ]);
    }

    public function reject(Booking $booking, int $adminId): bool
    {
        return $booking->update([
            'status'      => Booking::STATUS_REJECTED,
            'approved_by' => $adminId,
        ]);
    }

    public function cancel(Booking $booking): bool
    {
        return $booking->update([
            'status' => Booking::STATUS_CANCELLED,
        ]);
    }

    public function hasOverlap(int $roomId, string $bookingDate, string $startTime, string $endTime, ?int $excludeId = null): bool
    {
        $query = Booking::query()
            ->where('room_id', $roomId)
            ->where('booking_date', $bookingDate)
            ->where('status', Booking::STATUS_APPROVED)
            ->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($sub) use ($startTime, $endTime) {
                        $sub->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    public function getUserBookingCountForDate(int $userId, string $date, ?int $excludeId = null): int
    {
        $query = Booking::query()
            ->where('user_id', $userId)
            ->where('booking_date', $date)
            ->whereIn('status', [Booking::STATUS_PENDING, Booking::STATUS_APPROVED]);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->count();
    }
}
