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
     | Query Scopes
     ===================== */

    public function scopeSearch($query, ?string $search)
    {
        return $query->when(
            filled($search),
            fn($q) =>
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%")
        );
    }

    public function scopeActiveStatus($query, $status)
    {
        return $query->when(
            isset($status),
            fn($q) => $q->where('is_active', $status)
        );
    }
}
