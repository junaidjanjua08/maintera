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
    ];

    // Optional: define relationships (if needed)
    public function user()
    {
        return $this->belongsTo(User::class);
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

   
}
