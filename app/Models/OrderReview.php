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
        'service_quality',
        'communication',
        'punctuality',
        'professionalism',
    ];

    protected $casts = [
        'rating' => 'integer',
        'service_quality' => 'integer',
        'communication' => 'integer',
        'punctuality' => 'integer',
        'professionalism' => 'integer',
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

    /**
     * Get the overall rating as stars
     */
    public function getStarsAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    /**
     * Get the overall rating as percentage
     */
    public function getRatingPercentageAttribute()
    {
        return ($this->rating / 5) * 100;
    }

    /**
     * Get average of all category ratings
     */
    public function getAverageCategoryRatingAttribute()
    {
        $categories = [
            $this->service_quality,
            $this->communication,
            $this->punctuality,
            $this->professionalism
        ];
        
        $validCategories = array_filter($categories, function($rating) {
            return $rating !== null;
        });
        
        return count($validCategories) > 0 ? round(array_sum($validCategories) / count($validCategories), 1) : null;
    }

    /**
     * Get rating description
     */
    public function getRatingDescriptionAttribute()
    {
        return match($this->rating) {
            1 => 'Poor',
            2 => 'Fair',
            3 => 'Good',
            4 => 'Very Good',
            5 => 'Excellent',
            default => 'Not Rated'
        };
    }

    /**
     * Scope for recent reviews
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope for positive reviews (4-5 stars)
     */
    public function scopePositive($query)
    {
        return $query->where('rating', '>=', 4);
    }

    /**
     * Scope for negative reviews (1-2 stars)
     */
    public function scopeNegative($query)
    {
        return $query->where('rating', '<=', 2);
    }
}

