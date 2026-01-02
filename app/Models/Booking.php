<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

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

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /* ================= Scopes ================= */

    public function scopeStatus(Builder $query, $status)
    {
        return $query->when($status, fn($q) => $q->where('status', $status));
    }

    public function scopeForRoom(Builder $query, $roomId)
    {
        return $query->when($roomId, fn($q) => $q->where('room_id', $roomId));
    }

    public function scopeForUser(Builder $query, $userId)
    {
        return $query->when($userId, fn($q) => $q->where('user_id', $userId));
    }

    // Dipakai oleh Cron Job
    public function scopePending(Builder $query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    // Dipakai oleh Cron Job
    public function scopePastStartTime(Builder $query)
    {
        $now = now();
        return $query->where(function ($q) use ($now) {
            $q->where('booking_date', '<', $now->toDateString())
                ->orWhere(function ($sub) use ($now) {
                    $sub->where('booking_date', '=', $now->toDateString())
                        ->whereTime('start_time', '<=', $now->toTimeString());
                });
        });
    }

    // Dipakai untuk cek bentrok
    public function scopeActive(Builder $query)
    {
        return $query
            ->where('status', self::STATUS_APPROVED)
            ->where(function ($q) {
                $q->where('booking_date', '>', now()->toDateString())
                    ->orWhere(function ($sub) {
                        $sub->where('booking_date', '=', now()->toDateString())
                            ->whereTime('end_time', '>', now()->toTimeString());
                    });
            });
    }

    /* ================= Helper Methods (YANG HILANG TADI ADA DISINI) ================= */

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

    // INI DIA METHOD YANG MENYEBABKAN ERROR
    public function isActiveApproved(): bool
    {
        // Logic: Status Approved DAN Waktunya belum lewat
        return $this->status === self::STATUS_APPROVED &&
            ($this->booking_date->isFuture() ||
                ($this->booking_date->isToday() && now()->format('H:i:s') < $this->end_time));
    }
}
