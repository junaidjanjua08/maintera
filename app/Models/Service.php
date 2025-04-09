<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
    ];

    /**
     * Get the category that owns the service.
     */
    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    /**
     * The categories that belong to the service.
     */
    public function serviceCategories()
    {
        return $this->belongsToMany(ServiceCategory::class, 'service_category_service');
    }
}
