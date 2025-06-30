@extends('admin.app')

@section('content')
<style>
    /* Toggle Switch Styles */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    /* Avatar Styles */
    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.125rem;
        color: white;
        text-transform: uppercase;
    }

    .avatar-blue { background-color: #3B82F6; }
    .avatar-green { background-color: #10B981; }
    .avatar-purple { background-color: #8B5CF6; }
    .avatar-pink { background-color: #EC4899; }
    .avatar-orange { background-color: #F97316; }
    .avatar-teal { background-color: #14B8A6; }
</style>

<div class="min-h-screen bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Technician Management</h2>
        </div>

        <!-- Main Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100">
            <div class="overflow-x-auto w-full">
                <div class="min-w-[1024px]">
                    <table class="w-full divide-y divide-gray-200 table-fixed">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="w-1/4 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Technician
                                </th>
                                <th scope="col" class="w-1/4 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Contact Info
                                </th>
                                <th scope="col" class="w-1/6 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Profession
                                </th>
                                <th scope="col" class="w-1/6 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Fields of Work
                                </th>
                                <th scope="col" class="w-1/12 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Status
                                </th>
                                <th scope="col" class="w-1/12 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
        @forelse ($technicians as $technician)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @php
                                                $colors = ['avatar-blue', 'avatar-green', 'avatar-purple', 'avatar-pink', 'avatar-orange', 'avatar-teal'];
                                                $colorIndex = ord(strtolower(substr($technician->user->name, 0, 1))) % count($colors);
                                                $avatarColor = $colors[$colorIndex];
                                            @endphp
                                            <div class="h-10 w-10 rounded-full flex items-center justify-center text-white {{ $avatarColor }}">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $technician->user->name }}
                    </div>
                                            <div class="text-xs text-gray-500">
                                                ID: {{ $technician->user->id }}
                        </div>
                    </div>
                </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $technician->user->email }}</div>
                                    <div class="text-sm text-gray-500">{{ $technician->phone ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $technician->occupation ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">{{ $technician->experience ?? 'N/A' }} experience</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @if($technician->skills)
                                            {{ implode(', ', $technician->skills) }}
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Inactive
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-4">
                                        <form action="{{ route('admin.technicians.toggle-status', $technician->user) }}" method="POST" class="inline">
                        @csrf
                                            @method('PATCH')
                                            <label class="switch">
                                                <input type="checkbox" 
                                                    onchange="this.form.submit()"
                                                    {{ $technician->user->status === 'active' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                    </form>
                                        <a href="{{ route('admin.technicians.view', $technician->user) }}" 
                                           class="text-indigo-600 hover:text-indigo-900">
                                            View Profile
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12">
                                    <div class="flex flex-col items-center justify-center min-h-[400px]">
                                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-1">No Pending Technicians</h3>
                                        <p class="text-gray-500">There are currently no technician requests pending approval.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out" id="success-message">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        {{ session('success') }}
    </div>
</div>
@endif

@if(session('error'))
<div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out" id="error-message">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        {{ session('error') }}
    </div>
</div>
@endif

<script>
    // Auto-hide success/error messages after 3 seconds with fade effect
    setTimeout(function() {
        const messages = document.querySelectorAll('#success-message, #error-message');
        messages.forEach(message => {
            if (message) {
                message.style.opacity = '0';
                message.style.transform = 'translateY(1rem)';
                setTimeout(() => {
                    message.style.display = 'none';
                }, 300);
            }
        });
    }, 3000);
</script>
@endsection
