@extends('technician.index')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Notifications</h4>
                    <div>
                        <button class="btn btn-primary mark-all-read">Mark All as Read</button>
                    </div>
                </div>
                <div class="card-body">
                    @forelse($notifications as $notification)
                        <div class="notification-item p-3 border-bottom" data-id="{{ $notification->id }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-1">{{ $notification->data['message'] }}</h5>
                                    <p class="mb-1">
                                        <strong>Location:</strong> {{ $notification->data['location'] }}
                                    </p>
                                    <p class="mb-1">
                                        <strong>Scheduled:</strong> {{ \Carbon\Carbon::parse($notification->data['scheduled_at'])->format('M d, Y h:i A') }}
                                    </p>
                                    <small class="text-muted">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div class="d-flex gap-2">
                                    @if($notification->unread())
                                        <button class="btn btn-sm btn-light mark-as-read" data-id="{{ $notification->id }}">
                                            Mark as Read
                                        </button>
                                    @endif
                                    <button class="btn btn-sm btn-danger delete-notification" data-id="{{ $notification->id }}">
                                        <i class="icon-xs" data-feather="trash-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">No notifications found</p>
                        </div>
                    @endforelse

                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toastr notification setup (if you're using it)
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 5000
    };

    // Mark all as read
    document.querySelector('.mark-all-read')?.addEventListener('click', function() {
        const button = this;
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

        fetch('{{ route("technician.notifications.mark-all-as-read") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update UI for all notifications
                document.querySelectorAll('.notification-item').forEach(item => {
                    item.classList.remove('bg-light', 'unread-notification');
                });
                
                // Remove all mark-as-read buttons
                document.querySelectorAll('.mark-as-read').forEach(btn => btn.remove());
                
                // Update unread count if you have one
                updateUnreadCount();
                
                toastr.success(data.message || 'All notifications marked as read');
            } else {
                throw new Error(data.message || 'Failed to mark all as read');
            }
        })
        .catch(error => {
            toastr.error(error.message);
            console.error('Error:', error);
        })
        .finally(() => {
            button.disabled = false;
            button.textContent = 'Mark All as Read';
        });
    });

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
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Complete UI update
                notificationItem.classList.remove('unread-notification', 'font-weight-bold');
                notificationItem.classList.add('read-notification'); // Optional: add read styling
                
                // Update status text if you have it
                const statusBadge = notificationItem.querySelector('.notification-status');
                if (statusBadge) {
                    statusBadge.textContent = 'Read';
                    statusBadge.classList.remove('badge-primary');
                    statusBadge.classList.add('badge-secondary');
                }
                
                // Remove the button
                button.remove();
                
                toastr.success(data.message || 'Notification marked as read');
                
                // Update unread count
                updateUnreadCount();
            } else {
                throw new Error(data.message || 'Failed to mark as read');
            }
        })
        .catch(error => {
            toastr.error(error.message);
            button.disabled = false;
            button.textContent = 'Mark as Read';
        });
    });
});

    // Delete notification
    document.querySelectorAll('.delete-notification').forEach(button => {
        button.addEventListener('click', function() {
            if (!confirm('Are you sure you want to delete this notification?')) return;
            
            const button = this;
            const notificationId = button.dataset.id;
            const notificationItem = button.closest('.notification-item');
            
            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

            fetch(`/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    notificationItem.remove();
                    toastr.success(data.message || 'Notification deleted');
                    
                    // Update unread count if you have one
                    updateUnreadCount();
                } else {
                    throw new Error(data.message || 'Failed to delete notification');
                }
            })
            .catch(error => {
                toastr.error(error.message);
                console.error('Error:', error);
            })
            .finally(() => {
                button.disabled = false;
                button.textContent = 'Delete';
            });
        });
    });

    // Function to update unread count
    function updateUnreadCount() {
        fetch('{{ route("technician.notifications.unread-count") }}', {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const unreadCountElement = document.getElementById('unread-count');
            if (unreadCountElement) {
                unreadCountElement.textContent = data.count;
                
                // Optional: Hide if count is zero
                if (data.count === 0) {
                    unreadCountElement.style.display = 'none';
                } else {
                    unreadCountElement.style.display = 'inline-block';
                }
            }
        })
        .catch(error => console.error('Error updating unread count:', error));
    }
});
</script>

@endsection 