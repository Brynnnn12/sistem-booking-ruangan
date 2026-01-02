<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import ini biar Type Hinting jalan
use Illuminate\Database\Eloquent\Builder; // Import Builder

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

    /* ================= Relations (Pakai Type Hinting : BelongsTo) ================= */

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

    // <<< TAMBAHAN PENTING 1: Scope Pending (Biar Command baca lebih enak)
    public function scopePending(Builder $query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeForUser(Builder $query, $userId)
    {
        return $query->when($userId, fn($q) => $q->where('user_id', $userId));
    }

    // <<< TAMBAHAN PENTING 2: Logic Cron Job dipindah kesini
    // Mencari booking yang "Sudah lewat waktu mulainya"
    public function scopePastStartTime(Builder $query)
    {
        $now = now();
        return $query->where(function ($q) use ($now) {
            $q->where('booking_date', '<', $now->toDateString()) // Tanggal lampau
                ->orWhere(function ($sub) use ($now) {
                    $sub->where('booking_date', '=', $now->toDateString()) // Hari ini
                        ->whereTime('start_time', '<=', $now->toTimeString()); // Jam sudah lewat
                });
        });
    }

    public function scopeActive(Builder $query)
    {
        return $query
            ->where('status', self::STATUS_APPROVED)
            ->where(function ($q) {
                // Logic: Booking masih berlaku (Belum selesai)
                $q->where('booking_date', '>', now()->toDateString())
                    ->orWhere(function ($sub) {
                        $sub->where('booking_date', '=', now()->toDateString())
                            ->whereTime('end_time', '>', now()->toTimeString());
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
