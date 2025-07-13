@extends('admin.app')

@section('content')
<div class="min-h-screen bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Technician Profile</h2>
            <a href="{{ route('admin.inactive.technicians') }}" class="text-indigo-600 hover:text-indigo-900">
                <i class="fas fa-arrow-left mr-2"></i> Back to List
            </a>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-8">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @if($technicianProfile->profile_image)
                            <img src="{{ asset($technicianProfile->profile_image) }}" alt="{{ $technicianProfile->user->name }}" 
                                class="h-24 w-24 rounded-full border-4 border-white object-cover">
                        @else
                            <div class="h-24 w-24 rounded-full border-4 border-white bg-white flex items-center justify-center text-3xl font-bold text-blue-600">
                                {{ strtoupper(substr($technicianProfile->user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="ml-6 text-white">
                        <h3 class="text-2xl font-bold">{{ $technicianProfile->user->name }}</h3>
                        <p class="text-blue-100">{{ is_array($technicianProfile->occupation ?? null)
                            ? implode(', ', $technicianProfile->occupation)
                            : ($technicianProfile->occupation ?? 'N/A') }}</p>
                        <div class="mt-2">
                            <span class="px-3 py-1 text-sm rounded-full {{ $technicianProfile->user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($technicianProfile->user->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Contact Information -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Contact Information</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm text-gray-500">Email</label>
                                <p class="text-gray-800">{{ $technicianProfile->user->email }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Phone</label>
                                <p class="text-gray-800">{{ $technicianProfile->phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Address</label>
                                <p class="text-gray-800">
                                    {{ $technicianProfile->address }}<br>
                                    {{ $technicianProfile->street_number }} {{ $technicianProfile->route }}<br>
                                    {{ $technicianProfile->locality }}, {{ $technicianProfile->area }}<br>
                                    {{ $technicianProfile->state }} {{ $technicianProfile->postal_code }}<br>
                                    {{ $technicianProfile->country }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Professional Information</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm text-gray-500">Occupation</label>
                                <p class="text-gray-800">{{ is_array($technicianProfile->occupation ?? null)
                                    ? implode(', ', $technicianProfile->occupation)
                                    : ($technicianProfile->occupation ?? 'N/A') }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Experience</label>
                                <p class="text-gray-800">{{ $technicianProfile->experience ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Qualification</label>
                                <p class="text-gray-800">{{ $technicianProfile->qualification ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Skills</label>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @if($technicianProfile->skills)
                                        @foreach($technicianProfile->skills as $skill)
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                    @else
                                        <p class="text-gray-500">No skills listed</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Metrics -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Performance Metrics</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white rounded-lg p-4 text-center">
                                <p class="text-sm text-gray-500">Rating</p>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($technicianProfile->rating, 1) }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 text-center">
                                <p class="text-sm text-gray-500">Total Orders</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $technicianProfile->total_orders }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 text-center">
                                <p class="text-sm text-gray-500">Completed Orders</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $technicianProfile->completed_orders }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 text-center">
                                <p class="text-sm text-gray-500">Completion Rate</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    {{ $technicianProfile->total_orders > 0 ? round(($technicianProfile->completed_orders / $technicianProfile->total_orders) * 100) : 0 }}%
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bio -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">About</h4>
                        <p class="text-gray-800">{{ $technicianProfile->bio ?? 'No bio provided' }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex justify-end space-x-4">
                    <form action="{{ route('admin.technicians.toggle-status', $technicianProfile->user) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-4 py-2 rounded-md {{ $technicianProfile->user->status === 'active' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white">
                            {{ $technicianProfile->user->status === 'active' ? 'Deactivate Account' : 'Activate Account' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 