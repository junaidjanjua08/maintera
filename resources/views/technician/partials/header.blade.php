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
        <a class="btn btn-light btn-icon rounded-circle indicator
          indicator-primary text-muted" href="#" role="button"
          id="dropdownNotification" data-bs-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">
          <i class="icon-xs" data-feather="bell"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge" style="display: none;">
           <span class="notification-count badge badge-pill badge-danger">
    {{ count(auth()->user()->unreadNotifications) }}
</span>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
          aria-labelledby="dropdownNotification">
          <div class="">
            <div class="border-bottom px-3 pt-2 pb-3 d-flex
              justify-content-between align-items-center">
              <p class="mb-0 text-dark fw-medium fs-4">Notifications</p>
              <div>
                <button class="btn btn-link text-muted mark-all-read" style="display: none;">
                  Mark all as read
                </button>
                <a href="#" class="text-muted">
                  <span>
                    <i class="me-1 icon-xxs" data-feather="settings"></i>
                  </span>
                </a>
              </div>
            </div>
            <!-- List group -->
            <ul class="list-group list-group-flush notification-list-scroll">
              @forelse(auth()->user()->unreadNotifications as $notification)
                <li class="list-group-item bg-light notification-item" data-id="{{ $notification->id }}">
                  <a href="{{ route('technician.orders.requests') }}" class="text-muted">
                    <h5 class="fw-bold mb-1">New Service Request</h5>
                    <p class="mb-0">
                      {{ $notification->data['message'] }}
                      <br>
                      <small class="text-muted">
                        Location: {{ $notification->data['location'] }}
                        <br>
                        Scheduled: {{ \Carbon\Carbon::parse($notification->data['scheduled_at'])->format('M d, Y h:i A') }}
                      </small>
                    </p>
                  </a>
                  <button class="btn btn-sm btn-link text-danger delete-notification" data-id="{{ $notification->id }}">
                    <i class="icon-xs" data-feather="trash-2"></i>
                  </button>
                </li>
              @empty
                <li class="list-group-item">
                  <p class="text-muted mb-0">No new notifications</p>
                </li>
              @endforelse
            </ul>
            <div class="border-top px-3 py-2 text-center">
              <a href="{{ route('technician.notifications.index') }}" class="text-inherit fw-semi-bold">
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
                    markAllReadBtn.style.display = 'block';
                } else {
                    badge.style.display = 'none';
                    markAllReadBtn.style.display = 'none';
                }
            });
    }

    // Mark all as read
    document.querySelector('.mark-all-read')?.addEventListener('click', function(e) {
        e.preventDefault();
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
                // Remove all notification items
                document.querySelectorAll('.notification-item').forEach(item => item.remove());
                // Show "No new notifications" message
                const list = document.querySelector('.notification-list-scroll');
                list.innerHTML = '<li class="list-group-item"><p class="text-muted mb-0">No new notifications</p></li>';
            }
        });
    });

    // Delete notification
    document.querySelectorAll('.delete-notification').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const notificationId = this.dataset.id;
            
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
                    this.closest('.notification-item').remove();
                    updateNotificationCount();
                }
            });
        });
    });

    // Initial count update
    updateNotificationCount();
    
    // Update count every minute
    setInterval(updateNotificationCount, 60000);
});
</script>
