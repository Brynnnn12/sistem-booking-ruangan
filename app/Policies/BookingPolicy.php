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
        // Tidak bisa update booking yang sudah approved
        if ($booking->status === Booking::STATUS_APPROVED) {
            return false;
        }

        if ($user->hasRole('Admin')) {
            return true; // Admin bisa update pending booking
        }

        // Staff hanya bisa update booking pending miliknya sendiri
        return $booking->isOwnedBy($user) && $booking->status === Booking::STATUS_PENDING;
    }

    public function delete(User $user, Booking $booking): bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }

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
            return $booking->status === Booking::STATUS_PENDING;
        }

        return $booking->isOwnedBy($user)
            && $booking->status === Booking::STATUS_PENDING;
    }
}
