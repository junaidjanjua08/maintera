<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'technician_id',
        'status',
        'distance',
        'fare_offer',
        'accepted_at',
        'rejected_at'
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'distance' => 'decimal:2',
        'fare_offer' => 'decimal:2'
    ];

    /**
     * Get the order that owns the request.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the technician that owns the request.
     */
    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
} 