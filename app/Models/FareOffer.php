<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FareOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'technician_id',
        'proposed_price',
        'note',
        'status',
    ];

    /**
     * Get the order associated with this fare offer.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the technician (user) who made this fare offer.
     */
    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
