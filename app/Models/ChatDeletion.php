<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatDeletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'deleted_at'
    ];

    protected $casts = [
        'deleted_at' => 'datetime'
    ];

    /**
     * Get the user who deleted the chat.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order whose chat was deleted.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
