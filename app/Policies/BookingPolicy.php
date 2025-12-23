<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Staff']);
    }

    public function view(User $user, Booking $booking): bool
    {
        return $user->hasRole('Admin') || $booking->isOwnedBy($user);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Staff']);
    }

    public function update(User $user, Booking $booking): bool
    {
        if ($user->hasRole('Admin')) {
            return true; // Admin bisa update semua booking
        }

        // Staff hanya bisa update booking pending miliknya sendiri
        return $booking->isOwnedBy($user) && $booking->status === Booking::STATUS_PENDING;
    }

    public function delete(User $user, Booking $booking): bool
    {
        if ($user->hasRole('Admin')) {
            return true; // Admin bisa hapus semua booking
        }

        // Staff hanya bisa hapus booking pending miliknya sendiri
        return $booking->isOwnedBy($user) && $booking->status === Booking::STATUS_PENDING;
    }

    public function approve(User $user, Booking $booking): bool
    {
        return $user->hasRole('Admin') && $booking->isPending();
    }

    public function reject(User $user, Booking $booking): bool
    {
        return $user->hasRole('Admin') && $booking->isPending();
    }

    public function cancel(User $user, Booking $booking): bool
    {
        if ($user->hasRole('Admin')) {
            // Admin hanya bisa cancel booking yang belum disetujui
            return in_array($booking->status, [
                Booking::STATUS_PENDING,
                Booking::STATUS_REJECTED,
            ]);
        }

        return $booking->isOwnedBy($user)
            && in_array($booking->status, [
                Booking::STATUS_PENDING,
            ]);
    }
}
