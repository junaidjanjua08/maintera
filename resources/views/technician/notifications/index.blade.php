@extends('technician.index')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-bell me-2"></i>
                        Notifications
                    </h4>
                    <div>
                        <button class="btn btn-light btn-sm mark-all-read" id="markAllReadBtn" onclick="markAllAsRead()">
                            <i class="fas fa-check-double me-1"></i>
                            Mark All as Read
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    @forelse($notifications as $notification)
                        @php
                          // Handle both array and JSON string data
                          $notificationData = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
                          $message = $notificationData['message'] ?? 'New notification received';
                          $location = $notificationData['location'] ?? 'Location not specified';
                          $scheduledAt = $notificationData['scheduled_at'] ?? null;
                            $type = $notificationData['type'] ?? 'general';
                            $orderId = $notificationData['order_id'] ?? null;
                            
                            // Get icon based on notification type
                            $icon = match($type) {
                                'new_request' => 'fas fa-inbox text-primary',
                                'technician_fare_offer' => 'fas fa-dollar-sign text-success',
                                'order_completed' => 'fas fa-check-circle text-success',
                                'order_cancelled' => 'fas fa-times-circle text-danger',
                                default => 'fas fa-bell text-info'
                            };
                            
                            // Get redirect URL based on notification type
                            $redirectUrl = match($type) {
                                'new_request' => route('technician.orders.requests'),
                                'technician_fare_offer' => route('technician.orders.requests'),
                                'order_completed' => route('technician.orders.completed'),
                                'order_cancelled' => route('technician.orders.requests'),
                                'chat_available' => $orderId ? route('technician.chat.show', ['orderId' => $orderId]) : route('technician.chat.index'),
                                default => route('technician.notifications.index')
                            };
                        @endphp
                        <div class="notification-item p-4 border-bottom {{ $notification->unread() ? 'bg-light unread-notification' : '' }}" data-id="{{ $notification->id }}">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-3">
                                    <i class="{{ $icon }} fa-2x"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <a href="{{ $redirectUrl }}" class="text-decoration-none flex-grow-1 notification-link">
                                            <h6 class="mb-1 fw-bold {{ $notification->unread() ? 'text-primary' : 'text-dark' }}">
                                                {{ $message }}
                                            </h6>
                                        </a>
                                <div class="d-flex gap-2">
                                    @if($notification->unread())
                                                <button class="btn btn-sm btn-outline-primary mark-as-read" data-id="{{ $notification->id }}">
                                                    <i class="fas fa-check me-1"></i>
                                            Mark as Read
                                        </button>
                                    @endif
                                            <button class="btn btn-sm btn-outline-danger delete-notification" data-id="{{ $notification->id }}" title="Delete notification">
                                                <i class="fas fa-trash"></i>
                                    </button>
                                        </div>
                                    </div>
                                    
                                    <a href="{{ $redirectUrl }}" class="text-decoration-none notification-link">
                                        @if($location && $location !== 'Location not specified')
                                            <p class="mb-1 text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                <strong>Location:</strong> {{ $location }}
                                            </p>
                                        @endif
                                        
                                        @if($scheduledAt)
                                            <p class="mb-1 text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                <strong>Scheduled:</strong> {{ \Carbon\Carbon::parse($scheduledAt)->format('M d, Y h:i A') }}
                                            </p>
                                        @endif
                                        
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                            <span class="ms-2 text-primary" style="font-size: 0.8rem;">
                                                <i class="fas fa-external-link-alt me-1"></i>Click to view
                                            </span>
                                        </small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No notifications found</h5>
                            <p class="text-muted mb-0">You're all caught up!</p>
                        </div>
                    @endforelse

                    @if($notifications->hasPages())
                        <div class="p-3 border-top">
                            <nav aria-label="Notification pagination">
                                <ul class="pagination pagination-sm justify-content-center mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($notifications->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $notifications->previousPageUrl() }}" rel="prev">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @php
                                        $start = max(1, $notifications->currentPage() - 2);
                                        $end = min($notifications->lastPage(), $notifications->currentPage() + 2);
                                    @endphp
                                    
                                    {{-- Show first page if not in range --}}
                                    @if ($start > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $notifications->url(1) }}">1</a>
                                        </li>
                                        @if ($start > 2)
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                    @endif
                                    
                                    {{-- Show pages in range --}}
                                    @for ($page = $start; $page <= $end; $page++)
                                        @if ($page == $notifications->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $notifications->url($page) }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endfor
                                    
                                    {{-- Show last page if not in range --}}
                                    @if ($end < $notifications->lastPage())
                                        @if ($end < $notifications->lastPage() - 1)
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $notifications->url($notifications->lastPage()) }}">{{ $notifications->lastPage() }}</a>
                                        </li>
                                    @endif

                                    {{-- Next Page Link --}}
                                    @if ($notifications->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $notifications->nextPageUrl() }}" rel="next">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                            
                            {{-- Pagination Info --}}
                            <div class="text-center mt-2">
                                <small class="text-muted">
                                    Showing {{ $notifications->firstItem() ?? 0 }} to {{ $notifications->lastItem() ?? 0 }} 
                                    of {{ $notifications->total() }} notifications
                                </small>
                            </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%) !important;
    }
    
    .unread-notification {
        border-left: 4px solid #34495e !important;
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%) !important;
    }
    
    .notification-item {
        transition: all 0.3s ease;
    }
    
    .notification-item:hover {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%) !important;
        transform: translateX(5px);
    }
    
    .btn-outline-primary {
        border-color: #34495e !important;
        color: #34495e !important;
    }
    
    .btn-outline-primary:hover {
        background-color: #34495e !important;
        border-color: #34495e !important;
        color: white !important;
    }
    
    .btn-outline-danger {
        border-color: #e74c3c !important;
        color: #e74c3c !important;
    }
    
    .btn-outline-danger:hover {
        background-color: #e74c3c !important;
        border-color: #e74c3c !important;
        color: white !important;
    }
    
    .text-primary {
        color: #34495e !important;
    }
    
    .text-success {
        color: #27ae60 !important;
    }
    
    .text-danger {
        color: #e74c3c !important;
    }
    
    .text-info {
        color: #3498db !important;
    }
    
    /* Pagination Styles */
    .pagination {
        margin-bottom: 0;
    }
    
    .pagination .page-link {
        border: 1px solid #dee2e6;
        color: #6c757d;
        background-color: #fff;
        transition: all 0.3s ease;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .pagination .page-link:hover {
        background-color: #34495e;
        border-color: #34495e;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(52, 73, 94, 0.2);
    }
    
    .pagination .page-item.active .page-link {
        background-color: #34495e;
        border-color: #34495e;
        color: #fff;
        box-shadow: 0 2px 4px rgba(52, 73, 94, 0.3);
    }
    
    .pagination .page-item.disabled .page-link {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
        cursor: not-allowed;
    }
    
    .pagination .page-item.disabled .page-link:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
        transform: none;
        box-shadow: none;
    }
    
    /* Pagination info styling */
    .pagination-info {
        font-size: 0.8rem;
        color: #6c757d;
    }
</style>

<script>
// Global function to update unread count
function updateUnreadCount() {
    fetch('{{ route("technician.notifications.unread-count") }}')
        .then(response => response.json())
        .then(data => {
            // Update header notification count if it exists
            const headerBadge = document.querySelector('.notification-badge');
            const headerCount = document.querySelector('.notification-count');
            
            if (headerBadge && headerCount) {
                if (data.count > 0) {
                    headerBadge.style.display = 'block';
                    headerCount.textContent = data.count;
                } else {
                    headerBadge.style.display = 'none';
                }
            }
        })
        .catch(error => {
            console.error('Error updating unread count:', error);
        });
}

// Global function for mark all as read
function markAllAsRead() {
    const button = document.getElementById('markAllReadBtn');
    if (!button) {
        console.error('Button not found!');
        return;
    }
    
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

        fetch('{{ route("technician.notifications.mark-all-as-read") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
            }
        })
        .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update UI for all notifications
                document.querySelectorAll('.notification-item').forEach(item => {
                    item.classList.remove('bg-light', 'unread-notification');
                item.querySelector('h6')?.classList.remove('text-primary');
                item.querySelector('h6')?.classList.add('text-dark');
                });
                
                // Remove all mark-as-read buttons
                document.querySelectorAll('.mark-as-read').forEach(btn => btn.remove());
                
            // Update unread count
                updateUnreadCount();
                
            // Show success message
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || 'All notifications marked as read',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
            } else {
                throw new Error(data.message || 'Failed to mark all as read');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: error.message
            });
        } else {
            alert('Error: ' + error.message);
        }
        })
        .finally(() => {
            button.disabled = false;
        button.innerHTML = '<i class="fas fa-check-double me-1"></i>Mark All as Read';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Check if mark all read button exists
    const markAllReadBtn = document.querySelector('.mark-all-read');
    
    if (!markAllReadBtn) {
        console.error('Mark all read button not found!');
    }

    // Mark single notification as read
    document.querySelectorAll('.mark-as-read').forEach(button => {
    button.addEventListener('click', function() {
        const button = this;
        const notificationId = button.dataset.id;
        const notificationItem = button.closest('.notification-item');
        
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

        fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
        .then(data => {
            if (data.success) {
                    // Update UI
                    notificationItem.classList.remove('unread-notification');
                    notificationItem.querySelector('h6')?.classList.remove('text-primary');
                    notificationItem.querySelector('h6')?.classList.add('text-dark');
                
                // Remove the button
                button.remove();
                
                // Update unread count
                updateUnreadCount();
                    
                    // Show success message
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message || 'Notification marked as read',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
            } else {
                throw new Error(data.message || 'Failed to mark as read');
            }
        })
        .catch(error => {
                console.error('Error:', error);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: error.message
                    });
                }
            })
            .finally(() => {
            button.disabled = false;
                button.innerHTML = '<i class="fas fa-check me-1"></i>Mark as Read';
            });
    });
});

    // Delete notification
    document.querySelectorAll('.delete-notification').forEach(button => {
        button.addEventListener('click', function() {
            const notificationId = this.dataset.id;
            const notificationItem = this.closest('.notification-item');
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteNotification(notificationId, notificationItem);
                    }
                });
            } else {
                if (confirm('Are you sure you want to delete this notification?')) {
                    deleteNotification(notificationId, notificationItem);
                }
            }
        });
    });

    function deleteNotification(notificationId, notificationItem) {
        const button = notificationItem.querySelector('.delete-notification');
            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

            fetch(`/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
        .then(response => response.json())
            .then(data => {
                if (data.success) {
                // Remove the notification item with animation
                notificationItem.style.transition = 'all 0.3s ease';
                notificationItem.style.transform = 'translateX(-100%)';
                notificationItem.style.opacity = '0';
                
                setTimeout(() => {
                    notificationItem.remove();
                    
                    // Check if no notifications left
                    if (document.querySelectorAll('.notification-item').length === 0) {
                        location.reload();
                    }
                }, 300);
                
                // Update unread count
                    updateUnreadCount();
                
                // Show success message
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: data.message || 'Notification deleted successfully',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
                } else {
                    throw new Error(data.message || 'Failed to delete notification');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: error.message
                });
            }
            })
            .finally(() => {
                button.disabled = false;
            button.innerHTML = '<i class="fas fa-trash"></i>';
        });
    }



    // Initial unread count update
    updateUnreadCount();
    
    // Handle notification link clicks to mark as read
    document.addEventListener('click', function(e) {
        if (e.target.closest('.notification-link')) {
            const notificationItem = e.target.closest('.notification-item');
            const notificationId = notificationItem.dataset.id;
            
            // Mark notification as read when clicked
            if (notificationId) {
                fetch(`/notifications/${notificationId}/mark-as-read`, {
                    method: 'POST',
            headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
                    if (data.success) {
                        // Update UI to show as read
                        notificationItem.classList.remove('unread-notification');
                        notificationItem.querySelector('h6')?.classList.remove('text-primary');
                        notificationItem.querySelector('h6')?.classList.add('text-dark');
                        
                        // Remove mark-as-read button if it exists
                        const markAsReadBtn = notificationItem.querySelector('.mark-as-read');
                        if (markAsReadBtn) {
                            markAsReadBtn.remove();
                        }
                        
                        // Update notification count
                        updateUnreadCount();
                    }
                })
                .catch(error => {
                    console.error('Error marking notification as read:', error);
                });
            }
        }
    });
});
</script>

@endsection 