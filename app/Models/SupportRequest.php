<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    use HasFactory;

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'user_type',
        'user_id',
        'status',
        'priority',
        'attachments',
        'admin_notes',
        'assigned_to',
        'resolved_at'
    ];

    protected $casts = [
        'attachments' => 'array',
        'resolved_at' => 'datetime'
    ];

    /**
     * Get the user who submitted the request
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin assigned to handle this request
     */
    public function assignedAdmin()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'in_progress' => 'blue',
            'resolved' => 'green',
            'closed' => 'gray',
            default => 'gray'
        };
    }

    /**
     * Get the priority badge color
     */
    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'urgent' => 'red',
            default => 'yellow'
        };
    }

    /**
     * Get file type icon
     */
    public function getFileIcon($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
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
     * Check if request is resolved
     */
    public function isResolved()
    {
        return in_array($this->status, ['resolved', 'closed']);
    }

    /**
     * Check if request is urgent
     */
    public function isUrgent()
    {
        return $this->priority === 'urgent';
    }
}
