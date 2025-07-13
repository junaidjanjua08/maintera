<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        // 'service_id', // Uncomment if you add service_id later
        'description',
        'street_address',
        'city',
        'area',
        'sub_area',
        'latitude',
        'longitude',
        'payment_mode',
        'scheduled_at',
        'status',
        'cancellation_reason',
        'technician_id',
        'scheduled_at' => 'datetime',
    'media' => 'array',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    /**
     * Get the user (customer) who placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Order.php

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }


    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Service::class);
    }

    public function fareOffers()
{
    return $this->hasMany(FareOffer::class);
}

public function payment()
{
    return $this->hasOne(Payment::class);
}

public function review()
{
    return $this->hasOne(OrderReview::class);
}

public function chatMessages()
{
    return $this->hasMany(ChatMessage::class)->orderBy('created_at', 'asc');
}

public function unreadMessages($userId)
{
    return $this->chatMessages()
        ->where('sender_id', '!=', $userId)
        ->whereNull('read_at')
        ->count();
}

   
}
