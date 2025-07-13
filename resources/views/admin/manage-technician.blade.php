@extends('admin.app')

@section('content')
<div class="container mx-auto px-6 py-10">
    <!-- Heading -->
    <div class="text-center mb-12">
        <h2 class="text-5xl font-extrabold text-white mb-4 tracking-tight leading-tight">
            👨‍🔧 Manage Technicians
        </h2>
        <p class="text-xl text-gray-400 max-w-3xl mx-auto">Enable/disable technician accounts and manage their access to the platform.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Total Technicians</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $technicians->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Active Technicians</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $technicians->where('status', true)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Pending Approvals</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ $technicians->where('status', false)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-2xl font-semibold text-indigo-800">📋 Technician List</h3>
            <div class="flex gap-4">
                <form action="{{ route('admin.manage-technician') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search technicians..." class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none" style="margin: 5px">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </form>
               
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider w-16">Sr. No.</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider w-1/5">Name</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider w-1/4">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider w-1/4">Services</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider w-24">Status</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-600 uppercase tracking-wider w-40">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-gray-700 text-sm">
                    @forelse ($technicians as $index => $technician)
                    <tr class="hover:bg-indigo-50 transition duration-300">
                        <td class="px-6 py-4 font-semibold whitespace-nowrap">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium whitespace-nowrap">{{ $technician['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $technician['email'] }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-2">
                                @foreach ($technician['services'] as $service)
                                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-indigo-100 text-indigo-800 whitespace-nowrap">
                                        {{ $service }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <form action="{{ route('admin.technicians.toggle-status', $technician['id']) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           class="sr-only peer status-toggle" 
                                           {{ $technician['status'] ? 'checked' : '' }}
                                           onchange="this.form.submit()">
                                    <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500 hover:bg-gray-400 peer-checked:hover:bg-green-600"></div>
                                    <span class="ml-2 text-xs font-medium text-gray-700">{{ $technician['status'] ? 'Active' : 'Inactive' }}</span>
                                </label>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.technicians.view', $technician['id']) }}" 
                                   class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md text-sm transition-all duration-300">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View
                                </a>
                                <form action="{{ route('admin.technicians.delete', $technician['id']) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this technician? This action cannot be undone.')"
                                            class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow-md text-sm transition-all duration-300">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="text-lg font-medium">No technicians found</p>
                                <p class="text-sm text-gray-500">Add a new technician to get started</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($technicians->count() > 0)
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Showing {{ $technicians->count() }} technicians
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Previous
                    </button>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Next
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
// Enhanced Toggle Switch Functionality
document.addEventListener('DOMContentLoaded', function() {
    const toggleSwitches = document.querySelectorAll('.status-toggle');
    
    toggleSwitches.forEach(toggle => {
        toggle.addEventListener('change', function() {
            // Show loading state
            const form = this.closest('form');
            const statusText = this.parentElement.querySelector('span');
            
            // Add loading class to the toggle
            this.disabled = true;
            this.parentElement.style.opacity = '0.6';
            
            // Update status text immediately for better UX
            if (statusText) {
                statusText.textContent = this.checked ? 'Active' : 'Inactive';
                statusText.className = this.checked ? 'ml-2 text-xs font-medium text-green-700' : 'ml-2 text-xs font-medium text-gray-700';
            }
            
            // Submit the form
            form.submit();
        });
    });
    
    // Add success message display if there's a flash message
    @if(session('success'))
        showNotification('{{ session('success') }}', 'success');
    @endif
    
    @if(session('error'))
        showNotification('{{ session('error') }}', 'error');
    @endif
});

// Notification function
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Animate out and remove
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            // Auto-submit search form after typing stops
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.closest('form').submit();
            }, 500);
        });
    }
});
</script>
@endsection
