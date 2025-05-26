<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnicianProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'phone',
        'occupation',
        'experience',
        'qualification',
        'address',
        'street_number',
        'route',
        'locality',
        'area',
        'state',
        'postal_code',
        'country',
        'latitude',
        'longitude',
        'profile_image',
        'bio',
        'skills',
        'is_available',
        'rating',
        'total_orders',
        'completed_orders',
        'is_verified',
        'verified_at'
    ];

    protected $casts = [
        'skills' => 'array',
        'is_available' => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6',
        'rating' => 'decimal:2'
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 