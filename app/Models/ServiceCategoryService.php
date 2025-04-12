<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ServiceCategoryService extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'service_category_id', // Foreign key for service category
        'service_id', // Foreign key for service
    ];
}
