<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'sender_id',
        'sender_type',
        'message',
        'message_type',
        'file_path',
        'file_name',
        'file_size',
        'location_data',
        'read_at'
    ];

    protected $casts = [
        'location_data' => 'array',
        'read_at' => 'datetime'
    ];

    /**
     * Get the order associated with this chat.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the sender (user) of this message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the customer for this order.
     */
    public function customer()
    {
        return $this->order->customer;
    }

    /**
     * Get the technician for this order.
     */
    public function technician()
    {
        return $this->order->technician;
    }

    /**
     * Check if message is read.
     */
    public function isRead()
    {
        return $this->read_at !== null;
    }

    /**
     * Mark message as read.
     */
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    /**
     * Get file size in human readable format.
     */
    public function getFileSizeAttribute($value)
    {
        if (!$value) return null;
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = (int) $value;
        $unit = 0;
        
        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }
        
        return round($size, 2) . ' ' . $units[$unit];
    }

    /**
     * Get file icon based on file type.
     */
    public function getFileIcon()
    {
        if (!$this->file_name) return null;
        
        $extension = strtolower(pathinfo($this->file_name, PATHINFO_EXTENSION));
        
        return match($extension) {
            'pdf' => '📄',
            'doc', 'docx' => '📝',
            'xls', 'xlsx' => '📊',
            'ppt', 'pptx' => '📋',
            'jpg', 'jpeg', 'png', 'gif', 'webp' => '🖼️',
            'txt' => '📄',
            'zip', 'rar' => '📦',
            default => '📎'
        };
    }

    /**
     * Check if message is from customer.
     */
    public function isFromCustomer()
    {
        return $this->sender_type === 'customer';
    }

    /**
     * Check if message is from technician.
     */
    public function isFromTechnician()
    {
        return $this->sender_type === 'technician';
    }
}
