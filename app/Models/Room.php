<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'capacity',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /* =====================
     | Relationships
     ===================== */

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /* =====================
     | Query Scopes
     ===================== */

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when(
            filled($search),
            fn(Builder $q) =>
            $q->where(function (Builder $sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            })
        );
    }

    public function scopeActiveStatus(Builder $query, ?bool $status): Builder
    {
        return $query->when(
            !is_null($status),
            fn(Builder $q) => $q->where('is_active', $status)
        );
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
