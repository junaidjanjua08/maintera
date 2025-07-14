<header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
    <div
        class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300">
        <!-- Mobile hamburger -->
        <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
            onclick="toggleSideMenu()" aria-label="Menu">
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
        <!-- Search input -->
        <div class="flex justify-center flex-1 lg:mr-32">
            <div class="relative w-full max-w-xl mr-6 focus-within:text-purple-500">
                <div class="absolute inset-y-0 flex items-center pl-2">
                    
                </div>
                
            </div>
        </div>
        <ul class="flex items-center flex-shrink-0 space-x-6">
            <!-- Notifications menu -->
           
            <!-- Profile menu -->
            <li class="relative">
                <button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none"
                    onclick="toggleProfileMenu()" aria-label="Account" aria-haspopup="true">
                    <img class="object-cover w-8 h-8 rounded-full"
                        src="https://images.unsplash.com/photo-1502378735452-bc7d86632805?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=aa3a807e1bbdfd4364d1f449eaa96d82"
                        alt="" aria-hidden="true" />
                </button>
                <div id="profileMenu" class="hidden absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                    aria-label="submenu">
                   
                    <div class="flex">
                        <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200 text-left">
                                <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                <span>Log out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>

<script>
// Simple JavaScript for dropdown functionality
function toggleProfileMenu() {
    const menu = document.getElementById('profileMenu');
    const notificationsMenu = document.getElementById('notificationsMenu');
    
    // Close notifications menu if open
    if (notificationsMenu) {
        notificationsMenu.classList.add('hidden');
    }
    
    // Toggle profile menu
    if (menu) {
        menu.classList.toggle('hidden');
    }
}

function toggleNotificationsMenu() {
    const menu = document.getElementById('notificationsMenu');
    const profileMenu = document.getElementById('profileMenu');
    
    // Close profile menu if open
    if (profileMenu) {
        profileMenu.classList.add('hidden');
    }
    
    // Toggle notifications menu
    if (menu) {
        menu.classList.toggle('hidden');
    }
}

function toggleSideMenu() {
    // Add side menu toggle functionality if needed
    console.log('Side menu toggle clicked');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    const profileMenu = document.getElementById('profileMenu');
    const notificationsMenu = document.getElementById('notificationsMenu');
    
    // Check if click is outside profile menu
    if (profileMenu && !profileMenu.contains(event.target) && !event.target.closest('button[onclick="toggleProfileMenu()"]')) {
        profileMenu.classList.add('hidden');
    }
    
    // Check if click is outside notifications menu
    if (notificationsMenu && !notificationsMenu.contains(event.target) && !event.target.closest('button[onclick="toggleNotificationsMenu()"]')) {
        notificationsMenu.classList.add('hidden');
    }
});

// Close dropdowns when pressing Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const profileMenu = document.getElementById('profileMenu');
        const notificationsMenu = document.getElementById('notificationsMenu');
        
        if (profileMenu) {
            profileMenu.classList.add('hidden');
        }
        if (notificationsMenu) {
            notificationsMenu.classList.add('hidden');
        }
    }
});
</script>