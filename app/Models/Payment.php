<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'status',
        'amount',
        'transaction_id',
    ];

    // Relationship: each payment belongs to one order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

