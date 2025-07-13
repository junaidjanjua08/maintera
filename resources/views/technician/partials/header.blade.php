<div class="header @@classList">
  <!-- navbar -->
  @php
    $user = Auth::user()->load('TechnicianProfile');
@endphp
  <nav class="navbar-classic navbar navbar-expand-lg">
    <a id="nav-toggle" href="#"><i
        data-feather="menu"

        class="nav-icon me-2 icon-xs"></i></a>
    <div class="ms-lg-3 d-none d-md-none d-lg-block">
      <!-- Form -->
      <form class="d-flex align-items-center">
        <input type="search" class="form-control" placeholder="Search" />
      </form>
    </div>
    <!--Navbar nav -->
    <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">
      <li class="dropdown stopevent">
        <a class="btn btn-light btn-icon rounded-circle indicator indicator-primary text-muted position-relative" 
           href="#" role="button" id="dropdownNotification" data-bs-toggle="dropdown" 
           aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell icon-xs"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge" 
                style="display: {{ count(auth()->user()->unreadNotifications) > 0 ? 'block' : 'none' }}; font-size: 0.7rem; min-width: 18px; height: 18px; line-height: 18px;">
            <span class="notification-count">{{ count(auth()->user()->unreadNotifications) }}</span>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow-lg border-0" 
             aria-labelledby="dropdownNotification" style="min-width: 350px;">
          <div class="p-0">
            <div class="border-bottom px-3 pt-3 pb-2 d-flex justify-content-between align-items-center">
              <h6 class="mb-0 fw-bold text-dark">
                <i class="fas fa-bell me-2 text-primary"></i>
                Notifications
              </h6>
              <div>
                <button class="btn btn-sm btn-outline-primary mark-all-read" style="display: none;">
                  <i class="fas fa-check-double me-1"></i>
                  Mark all as read
                </button>
                <a href="{{ route('technician.notifications.index') }}" class="btn btn-sm btn-link text-muted" title="View all notifications">
                  <i class="fas fa-external-link-alt"></i>
                </a>
              </div>
            </div>
            
            <!-- List group -->
            <div class="notification-list-scroll" style="max-height: 400px; overflow-y: auto;">
              @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
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
                      'order_accepted' => 'fas fa-check-circle text-success',
                      'order_in_progress' => 'fas fa-tools text-info',
                      'order_completed' => 'fas fa-check-double text-success',
                      'order_cancelled' => 'fas fa-times-circle text-danger',
                      'order_status_updated' => 'fas fa-info-circle text-primary',
                      'chat_available' => 'fas fa-comments text-info',
                      default => 'fas fa-bell text-info'
                  };
                  
                  // Get redirect URL based on notification type
                  $redirectUrl = match($type) {
                      'new_request' => route('technician.orders.requests'),
                      'technician_fare_offer' => route('technician.orders.requests'),
                      'order_accepted' => route('technician.orders.pending'),
                      'order_in_progress' => route('technician.orders.pending'),
                      'order_completed' => route('technician.orders.completed'),
                      'order_cancelled' => route('technician.orders.requests'),
                      'order_status_updated' => route('technician.orders.requests'),
                      'chat_available' => $orderId ? route('technician.chat.show', ['orderId' => $orderId]) : route('technician.chat.index'),
                      default => route('technician.notifications.index')
                  };
                @endphp
                <div class="list-group-item border-0 notification-item p-3" data-id="{{ $notification->id }}">
                  <div class="d-flex align-items-start">
                    <div class="flex-shrink-0 me-3">
                      <i class="{{ $icon }} fa-lg"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between align-items-start mb-1">
                        <a href="{{ $redirectUrl }}" class="text-decoration-none flex-grow-1 notification-link">
                          <h6 class="mb-1 fw-bold text-dark" style="font-size: 0.9rem;">
                            {{ Str::limit($message, 50) }}
                          </h6>
                        </a>
                        <button class="btn btn-sm btn-link text-danger p-0 delete-notification ms-2" 
                                data-id="{{ $notification->id }}" title="Delete notification">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                      
                      <a href="{{ $redirectUrl }}" class="text-decoration-none notification-link">
                        @if($location && $location !== 'Location not specified')
                          <p class="mb-1 text-muted" style="font-size: 0.8rem;">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ Str::limit($location, 40) }}
                          </p>
                        @endif
                        
                        @if($scheduledAt)
                          <p class="mb-1 text-muted" style="font-size: 0.8rem;">
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ \Carbon\Carbon::parse($scheduledAt)->format('M d, h:i A') }}
                          </p>
                        @endif
                        
                        <small class="text-muted" style="font-size: 0.75rem;">
                          <i class="fas fa-clock me-1"></i>
                          {{ $notification->created_at->diffForHumans() }}
                          <span class="ms-2 text-primary" style="font-size: 0.7rem;">
                            <i class="fas fa-external-link-alt me-1"></i>Click to view
                          </span>
                        </small>
                      </a>
                    </div>
                  </div>
                </div>
              @empty
                <div class="text-center py-4">
                  <i class="fas fa-bell-slash fa-2x text-muted mb-2"></i>
                  <p class="text-muted mb-0" style="font-size: 0.9rem;">No new notifications</p>
                </div>
              @endforelse
            </div>
            
            <div class="border-top px-3 py-2 text-center">
              <a href="{{ route('technician.notifications.index') }}" 
                 class="text-decoration-none fw-semi-bold text-primary">
                <i class="fas fa-eye me-1"></i>
                View all Notifications
              </a>
            </div>
          </div>
        </div>
      </li>
      <!-- List -->
      <li class="dropdown ms-2">
        <a class="rounded-circle" href="#" role="button" id="dropdownUser"
          data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="avatar avatar-md avatar-indicators avatar-online">
           <img alt="avatar" src="{{ $user->TechnicianProfile?->profile_image ? asset($user->TechnicianProfile->profile_image) : asset('images/avatar.png') }}" class="rounded-circle" />
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end"
          aria-labelledby="dropdownUser">
          <div class="px-4 pb-0 pt-2">


            <div class="lh-1 ">
              <h5 class="mb-1">{{ $user->name }}</h5>
              <a href="#" class="text-inherit fs-6">View my profile</a>
            </div>
            <div class=" dropdown-divider mt-3 mb-2"></div>
          </div>

          <ul class="list-unstyled">
            <!-- Edit Profile -->
            <li>
                <a class="dropdown-item" href="{{ route('technician.editprofile') }}">
                    <i class="me-2 icon-xxs dropdown-item-icon" data-feather="user"></i> Edit Profile
                </a>
            </li>
      
            <!-- Account Settings -->
            <li>
                <a class="dropdown-item" href="{{ route('technician.settings') }}">
                    <i class="me-2 icon-xxs dropdown-item-icon" data-feather="settings"></i> Account Settings
                </a>
            </li>
        
            <!-- Logout -->
            <li>
                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                        <i class="me-2 icon-xxs dropdown-item-icon" data-feather="log-out"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
        
  </nav>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to update notification count
    function updateNotificationCount() {
        fetch('{{ route("technician.notifications.unread-count") }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.notification-badge');
                const count = document.querySelector('.notification-count');
                const markAllReadBtn = document.querySelector('.mark-all-read');
                
                if (data.count > 0) {
                    badge.style.display = 'block';
                    count.textContent = data.count;
                    markAllReadBtn.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                    markAllReadBtn.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error updating notification count:', error);
            });
    }

    // Mark all as read
    document.querySelector('.mark-all-read')?.addEventListener('click', function(e) {
        e.preventDefault();
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
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateNotificationCount();
                // Remove all notification items with animation
                document.querySelectorAll('.notification-item').forEach(item => {
                    item.style.transition = 'all 0.3s ease';
                    item.style.transform = 'translateX(-100%)';
                    item.style.opacity = '0';
                    setTimeout(() => item.remove(), 300);
                });
                
                // Show "No new notifications" message
                setTimeout(() => {
                    const list = document.querySelector('.notification-list-scroll');
                    list.innerHTML = '<div class="text-center py-4"><i class="fas fa-bell-slash fa-2x text-muted mb-2"></i><p class="text-muted mb-0" style="font-size: 0.9rem;">No new notifications</p></div>';
                }, 300);
                
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
            }
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = '<i class="fas fa-check-double me-1"></i>Mark all as read';
        });
    });

    // Delete notification
    document.querySelectorAll('.delete-notification').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const notificationId = this.dataset.id;
            const notificationItem = this.closest('.notification-item');
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Delete Notification?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
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
                        const list = document.querySelector('.notification-list-scroll');
                        list.innerHTML = '<div class="text-center py-4"><i class="fas fa-bell-slash fa-2x text-muted mb-2"></i><p class="text-muted mb-0" style="font-size: 0.9rem;">No new notifications</p></div>';
                    }
                }, 300);
                
                // Update unread count
                updateNotificationCount();
                
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
            button.innerHTML = '<i class="fas fa-times"></i>';
        });
    }

    // Initial count update
    updateNotificationCount();
    
    // Update count every 30 seconds for real-time updates
    setInterval(updateNotificationCount, 30000);
    
    // Add real-time notification sound (optional)
    function playNotificationSound() {
        const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmGgU7k9n1unEiBC13yO/eizEIHWq+8+OWT');
        audio.volume = 0.3;
        audio.play().catch(e => console.log('Audio play failed:', e));
    }
    
    // Check for new notifications and play sound
    let lastNotificationCount = 0;
    function checkNewNotifications() {
        fetch('{{ route("technician.notifications.unread-count") }}')
            .then(response => response.json())
            .then(data => {
                if (data.count > lastNotificationCount && lastNotificationCount > 0) {
                    // New notification received
                    playNotificationSound();
                    
                    // Show a toast notification
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'info',
                            title: 'New Notification!',
                            text: 'You have a new notification',
                            timer: 3000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                    }
                }
                lastNotificationCount = data.count;
            })
            .catch(error => {
                console.error('Error checking new notifications:', error);
            });
    }
    
    // Check for new notifications every 10 seconds
    setInterval(checkNewNotifications, 10000);
    
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
                        
                        // Update notification count
                        updateNotificationCount();
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
