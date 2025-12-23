<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public const STATUS_PENDING   = 'pending';
    public const STATUS_APPROVED  = 'approved';
    public const STATUS_REJECTED  = 'rejected';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'room_id',
        'user_id',
        'approved_by',
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'note',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    /* ================= Relations ================= */

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /* ================= Scopes ================= */

    public function scopeStatus($query, $status)
    {
        return $query->when($status, fn($q) => $q->where('status', $status));
    }

    public function scopeForUser($query, $userId)
    {
        return $query->when($userId, fn($q) => $q->where('user_id', $userId));
    }

    public function scopeForRoom($query, $roomId)
    {
        return $query->when($roomId, fn($q) => $q->where('room_id', $roomId));
    }

    public function scopeActive($query)
    {
        return $query
            ->where('status', self::STATUS_APPROVED)
            ->where(function ($q) {
                $q->where('booking_date', '>', now()->toDateString())
                    ->orWhere(function ($sub) {
                        $sub->where('booking_date', '=', now()->toDateString())
                            ->whereTime('end_time', '>', now()->format('H:i:s'));
                    });
            });
    }

    /* ================= Helper Methods ================= */

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isOwnedBy(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    public function canBeModifiedBy(User $user): bool
    {
        return $this->isOwnedBy($user) && $this->isPending();
    }
}
