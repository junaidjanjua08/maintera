<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Get the services for the service category.
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'category_id'); // Ensure the correct foreign key
    }
    public function order()
    {
        return $this->hasMany(Order::class, 'subcategory_id'); // Ensure the correct foreign key
    }

}

