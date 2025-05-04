<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_id',
        'technician_id',
        'rating',
        'review',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id')->where('role', 'customer');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id')->where('role', 'technician');
    }
}

