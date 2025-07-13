@extends('index')

@section('content')
<style>
    .notification-container {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .notification-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .notification-header h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }

    .notification-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 1rem;
    }

    .notification-stats {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-top: 1.5rem;
    }

    .stat-item {
        text-align: center;
        background: rgba(255, 255, 255, 0.1);
        padding: 1rem 1.5rem;
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        display: block;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .notification-actions {
        background: #f8f9fa;
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        color: white;
    }

    .btn-outline-secondary {
        background: transparent;
        color: #6c757d;
        border: 2px solid #6c757d;
    }

    .btn-outline-secondary:hover {
        background: #6c757d;
        color: white;
        transform: translateY(-2px);
    }

    .notification-list {
        max-height: 600px;
        overflow-y: auto;
    }

    .notification-item {
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
        transition: all 0.3s ease;
        position: relative;
    }

    .notification-item:hover {
        background: #f8f9fa;
    }

    .notification-item.unread {
        background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
        border-left: 4px solid #667eea;
    }

    .notification-item.unread:hover {
        background: linear-gradient(135deg, #bbdefb 0%, #e1bee7 100%);
    }

    .notification-content {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .notification-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .icon-fare-offer {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }

    .icon-order-accepted {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
    }

    .icon-order-in-progress {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: white;
    }

    .icon-order-completed {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }

    .icon-order-cancelled {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }

    .icon-status-updated {
        background: linear-gradient(135deg, #6f42c1 0%, #5a2d91 100%);
        color: white;
    }

    .icon-default {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
    }

    .notification-details {
        flex-grow: 1;
    }

    .notification-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .notification-message {
        color: #666;
        margin-bottom: 0.75rem;
        line-height: 1.5;
    }

    .notification-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .notification-time {
        color: #999;
        font-size: 0.9rem;
    }

    .notification-actions-item {
        display: flex;
        gap: 0.5rem;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        border-radius: 8px;
    }

    .btn-outline-primary {
        background: transparent;
        color: #007bff;
        border: 1px solid #007bff;
    }

    .btn-outline-primary:hover {
        background: #007bff;
        color: white;
    }

    .btn-outline-danger {
        background: transparent;
        color: #dc3545;
        border: 1px solid #dc3545;
    }

    .btn-outline-danger:hover {
        background: #dc3545;
        color: white;
    }

    .unread-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 12px;
        height: 12px;
        background: #dc3545;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        margin-bottom: 0.5rem;
        color: #495057;
    }

    .empty-state p {
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }

    .pagination-container {
        background: #f8f9fa;
        padding: 1.5rem;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 0.5rem;
    }

    .page-item {
        margin: 0;
    }

    .page-link {
        padding: 0.75rem 1rem;
        border: 1px solid #dee2e6;
        background: white;
        color: #007bff;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: #007bff;
        color: white;
        border-color: #007bff;
    }

    .page-item.active .page-link {
        background: #007bff;
        color: white;
        border-color: #007bff;
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background: #f8f9fa;
        border-color: #dee2e6;
    }

    .loading-spinner {
        display: none;
        text-align: center;
        padding: 2rem;
    }

    .fade-out {
        opacity: 0;
        transform: translateX(-100%);
        transition: all 0.3s ease;
    }

    @media (max-width: 768px) {
        .notification-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .action-buttons {
            justify-content: center;
        }

        .notification-meta {
            flex-direction: column;
            align-items: flex-start;
        }

        .notification-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .notification-icon {
            align-self: center;
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="notification-container">
                <!-- Header -->
                <div class="notification-header">
                    <h1><i class="fas fa-bell me-3"></i>Notifications</h1>
                    <p>Stay updated with your order status and important updates</p>
                    
                    <div class="notification-stats">
                        <div class="stat-item">
                            <span class="stat-number" id="totalNotifications">{{ $notifications->total() }}</span>
                            <span class="stat-label">Total</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" id="unreadCount">{{ auth()->user()->unreadNotifications->count() }}</span>
                            <span class="stat-label">Unread</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" id="readCount">{{ auth()->user()->readNotifications->count() }}</span>
                            <span class="stat-label">Read</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="notification-actions">
                    <div class="action-buttons">
                        <button class="btn btn-success" onclick="markAllAsRead()" id="markAllReadBtn">
                            <i class="fas fa-check-double"></i>
                            Mark All as Read
                        </button>
                        <button class="btn btn-outline-secondary" onclick="refreshNotifications()">
                            <i class="fas fa-sync-alt"></i>
                            Refresh
                        </button>
                    </div>
                    
                    <div class="notification-filters">
                        <select class="form-select" id="filterSelect" onchange="filterNotifications()">
                            <option value="all">All Notifications</option>
                            <option value="unread">Unread Only</option>
                            <option value="read">Read Only</option>
                        </select>
                    </div>
                </div>

                <!-- Loading Spinner -->
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <!-- Notification List -->
                <div class="notification-list" id="notificationList">
                    @forelse($notifications as $notification)
                        @php
                            $notificationData = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
                            $type = $notificationData['type'] ?? '';
                            $message = $notificationData['message'] ?? 'Notification';
                            $orderId = $notificationData['order_id'] ?? null;
                            $technicianName = $notificationData['technician_name'] ?? '';
                            $serviceName = $notificationData['service_name'] ?? '';
                            $location = $notificationData['location'] ?? '';
                            
                            // Get icon class based on notification type
                            $iconClass = match($type) {
                                'technician_fare_offer' => 'icon-fare-offer fas fa-dollar-sign',
                                'order_accepted' => 'icon-order-accepted fas fa-check-circle',
                                'order_in_progress' => 'icon-order-in-progress fas fa-tools',
                                'order_completed' => 'icon-order-completed fas fa-check-double',
                                'order_cancelled' => 'icon-order-cancelled fas fa-times-circle',
                                'order_status_updated' => 'icon-status-updated fas fa-info-circle',
                                default => 'icon-default fas fa-bell'
                            };
                            
                            // Get redirect URL based on notification type
                            $redirectUrl = match($type) {
                                'technician_fare_offer' => $orderId ? route('customer.order.fares', $orderId) : route('customer.orders'),
                                'order_accepted', 'order_in_progress', 'order_completed', 'order_cancelled', 'order_status_updated' => route('customer.orders'),
                                default => route('customer.orders')
                            };
                        @endphp
                        
                        <div class="notification-item {{ $notification->read_at ? '' : 'unread' }}" data-id="{{ $notification->id }}" data-type="{{ $type }}">
                            @if(!$notification->read_at)
                                <div class="unread-badge"></div>
                            @endif
                            
                            <div class="notification-content">
                                <div class="notification-icon {{ $iconClass }}"></div>
                                
                                <div class="notification-details">
                                    <div class="notification-title">
                                        @switch($type)
                                            @case('technician_fare_offer')
                                                New Fare Offer
                                                @break
                                            @case('order_accepted')
                                                Order Accepted
                                                @break
                                            @case('order_in_progress')
                                                Work Started
                                                @break
                                            @case('order_completed')
                                                Order Completed
                                                @break
                                            @case('order_cancelled')
                                                Order Cancelled
                                                @break
                                            @case('order_status_updated')
                                                Status Updated
                                                @break
                                            @default
                                                Notification
                                        @endswitch
                                    </div>
                                    
                                    <div class="notification-message">
                                        {{ $message }}
                                        @if($technicianName)
                                            <br><small class="text-muted">Technician: {{ $technicianName }}</small>
                                        @endif
                                        @if($serviceName)
                                            <br><small class="text-muted">Service: {{ $serviceName }}</small>
                                        @endif
                                        @if($location)
                                            <br><small class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ $location }}</small>
                                        @endif
                                        @if($notificationData['reason'] ?? false)
                                            <br><small class="text-danger"><strong>Reason:</strong> {{ $notificationData['reason'] }}</small>
                                        @endif
                                    </div>
                                    
                                    <div class="notification-meta">
                                        <div class="notification-time">
                                            <i class="fas fa-clock"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </div>
                                        
                                        <div class="notification-actions-item">
                                            <a href="{{ $redirectUrl }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                            
                                            @if(!$notification->read_at)
                                                <button class="btn btn-sm btn-success" onclick="markAsRead('{{ $notification->id }}')">
                                                    <i class="fas fa-check"></i>
                                                    Mark Read
                                                </button>
                                            @endif
                                            
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteNotification('{{ $notification->id }}')">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-bell-slash"></i>
                            <h3>No notifications yet</h3>
                            <p>You'll see notifications here when you receive updates about your orders.</p>
                            <a href="{{ route('customer.orders') }}" class="btn btn-primary">
                                <i class="fas fa-clipboard-list me-2"></i>View My Orders
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($notifications->hasPages())
                    <div class="pagination-container">
                        {{ $notifications->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Mark single notification as read
function markAsRead(notificationId) {
    fetch(`/customer/notifications/${notificationId}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notificationItem = document.querySelector(`[data-id="${notificationId}"]`);
            if (notificationItem) {
                notificationItem.classList.remove('unread');
                const unreadBadge = notificationItem.querySelector('.unread-badge');
                if (unreadBadge) {
                    unreadBadge.remove();
                }
                
                // Update the mark read button
                const markReadBtn = notificationItem.querySelector('.btn-success');
                if (markReadBtn) {
                    markReadBtn.remove();
                }
            }
            
            updateNotificationCounts();
            showSuccessMessage('Notification marked as read');
        } else {
            showErrorMessage('Failed to mark notification as read');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorMessage('An error occurred');
    });
}

// Mark all notifications as read
function markAllAsRead() {
    const button = document.getElementById('markAllReadBtn');
    const originalText = button.innerHTML;
    
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    
    fetch('/customer/notifications/mark-all-as-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove unread styling from all notifications
            document.querySelectorAll('.notification-item.unread').forEach(item => {
                item.classList.remove('unread');
                const unreadBadge = item.querySelector('.unread-badge');
                if (unreadBadge) {
                    unreadBadge.remove();
                }
                
                // Remove mark read buttons
                const markReadBtn = item.querySelector('.btn-success');
                if (markReadBtn) {
                    markReadBtn.remove();
                }
            });
            
            updateNotificationCounts();
            showSuccessMessage('All notifications marked as read');
        } else {
            showErrorMessage('Failed to mark all notifications as read');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorMessage('An error occurred');
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = originalText;
    });
}

// Delete notification
function deleteNotification(notificationId) {
    if (!confirm('Are you sure you want to delete this notification?')) {
        return;
    }
    
    fetch(`/customer/notifications/${notificationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notificationItem = document.querySelector(`[data-id="${notificationId}"]`);
            if (notificationItem) {
                notificationItem.classList.add('fade-out');
                setTimeout(() => {
                    notificationItem.remove();
                    updateNotificationCounts();
                }, 300);
            }
            showSuccessMessage('Notification deleted successfully');
        } else {
            showErrorMessage('Failed to delete notification');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorMessage('An error occurred');
    });
}

// Filter notifications
function filterNotifications() {
    const filter = document.getElementById('filterSelect').value;
    const notifications = document.querySelectorAll('.notification-item');
    
    notifications.forEach(notification => {
        if (filter === 'all') {
            notification.style.display = 'block';
        } else if (filter === 'unread') {
            notification.style.display = notification.classList.contains('unread') ? 'block' : 'none';
        } else if (filter === 'read') {
            notification.style.display = !notification.classList.contains('unread') ? 'block' : 'none';
        }
    });
}

// Refresh notifications
function refreshNotifications() {
    const spinner = document.getElementById('loadingSpinner');
    const list = document.getElementById('notificationList');
    
    spinner.style.display = 'block';
    list.style.opacity = '0.5';
    
    setTimeout(() => {
        location.reload();
    }, 500);
}

// Update notification counts
function updateNotificationCounts() {
    fetch('/customer/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('unreadCount').textContent = data.count;
                document.getElementById('readCount').textContent = 
                    parseInt(document.getElementById('totalNotifications').textContent) - data.count;
            }
        })
        .catch(error => {
            console.error('Error updating counts:', error);
        });
}

// Show success message
function showSuccessMessage(message) {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: message,
        timer: 2000,
        showConfirmButton: false
    });
}

// Show error message
function showErrorMessage(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Error: ' + message
    });
}

// Auto-refresh notification counts every 30 seconds
setInterval(updateNotificationCounts, 30000);

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateNotificationCounts();
});
</script>
@endsection 