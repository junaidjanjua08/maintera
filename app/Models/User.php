<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the technician profile associated with the user.
     */
    public function technicianProfile()
    {
        return $this->hasOne(TechnicianProfile::class);
    }

    public function fareOffers()
    {
        return $this->hasMany(FareOffer::class, 'technician_id');
    }

    // If the user is a customer
    public function givenReviews()
    {
        return $this->hasMany(OrderReview::class, 'customer_id');
    }

    // If the user is a technician
    public function receivedReviews()
    {
        return $this->hasMany(OrderReview::class, 'technician_id');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Scope a query to only include technicians.
     */
    public function scopeTechnicians($query)
    {
        return $query->where('role', 'technician');
    }

    /**
     * Get unread chat messages count for customer.
     */
    public function getUnreadChatMessagesCount()
    {
        if ($this->role !== 'customer') {
            return 0;
        }

        return ChatMessage::whereHas('order', function ($query) {
            $query->where('user_id', $this->id);
        })
        ->where('sender_id', '!=', $this->id)
        ->whereNull('read_at')
        ->count();
    }

    /**
     * Get unread chat messages count for technician.
     */
    public function getUnreadChatMessagesCountForTechnician()
    {
        if ($this->role !== 'technician') {
            return 0;
        }

        return ChatMessage::whereHas('order', function ($query) {
            $query->where('technician_id', $this->id);
        })
        ->where('sender_id', '!=', $this->id)
        ->whereNull('read_at')
        ->count();
    }

    /**
     * Get unread notifications count for customer.
     */
    public function getUnreadNotificationsCount()
    {
        return $this->unreadNotifications->count();
    }

    /**
     * Get read notifications count for customer.
     */
    public function getReadNotificationsCount()
    {
        return $this->readNotifications->count();
    }

    /**
     * Get chat deletions for this user.
     */
    public function chatDeletions()
    {
        return $this->hasMany(ChatDeletion::class);
    }

    /**
     * Check if a user has deleted a specific order's chat.
     */
    public function hasDeletedChat($orderId)
    {
        return $this->chatDeletions()->where('order_id', $orderId)->exists();
    }

    /**
     * Delete a chat for this user (soft delete).
     */
    public function deleteChat($orderId)
    {
        return $this->chatDeletions()->updateOrCreate(
            ['order_id' => $orderId],
            ['deleted_at' => now()]
        );
    }

    /**
     * Get average rating for technician
     */
    public function getAverageRatingAttribute()
    {
        if ($this->role !== 'technician') {
            return null;
        }

        return $this->receivedReviews()->avg('rating') ?? 0;
    }

    /**
     * Get total reviews count for technician
     */
    public function getTotalReviewsAttribute()
    {
        if ($this->role !== 'technician') {
            return 0;
        }

        return $this->receivedReviews()->count();
    }

    /**
     * Get rating distribution for technician
     */
    public function getRatingDistributionAttribute()
    {
        if ($this->role !== 'technician') {
            return [];
        }

        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = $this->receivedReviews()->where('rating', $i)->count();
            $percentage = $this->total_reviews > 0 ? round(($count / $this->total_reviews) * 100, 1) : 0;
            $distribution[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }

        return $distribution;
    }

    /**
     * Get recent reviews for technician
     */
    public function getRecentReviews($limit = 5)
    {
        if ($this->role !== 'technician') {
            return collect();
        }

        return $this->receivedReviews()
            ->with(['customer', 'order'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get positive reviews (4-5 stars) for technician
     */
    public function getPositiveReviewsCount()
    {
        if ($this->role !== 'technician') {
            return 0;
        }

        return $this->receivedReviews()->where('rating', '>=', 4)->count();
    }

    /**
     * Get negative reviews (1-2 stars) for technician
     */
    public function getNegativeReviewsCount()
    {
        if ($this->role !== 'technician') {
            return 0;
        }

        return $this->receivedReviews()->where('rating', '<=', 2)->count();
    }

    /**
     * Get rating stars display
     */
    public function getRatingStarsAttribute()
    {
        $rating = $this->average_rating;
        if (!$rating) return str_repeat('☆', 5);
        
        $fullStars = floor($rating);
        $hasHalfStar = $rating - $fullStars >= 0.5;
        
        $stars = str_repeat('★', $fullStars);
        if ($hasHalfStar) $stars .= '☆';
        $stars .= str_repeat('☆', 5 - $fullStars - ($hasHalfStar ? 1 : 0));
        
        return $stars;
    }
}
