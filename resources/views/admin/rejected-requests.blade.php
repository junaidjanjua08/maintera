@extends('admin.app')

@section('content')
<div class="min-h-screen bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Rejected Technician Requests</h2>
    </div>

        <!-- Main Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100">
            <div class="overflow-x-auto w-full">
                <div class="min-w-[1024px]">
                    <table class="w-full divide-y divide-gray-200 table-fixed">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="w-1/6 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Technician
                                </th>
                                <th scope="col" class="w-1/6 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Contact Info
                                </th>
                                <th scope="col" class="w-1/6 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Professional Info
                                </th>
                                <th scope="col" class="w-1/6 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Skills & Services
                                </th>
                                <th scope="col" class="w-1/6 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Fields of Work
                                </th>
                                <th scope="col" class="w-1/6 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
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
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $technician['name'] }}</div>
                                            <div class="text-sm text-gray-500">{{ $technician['occupation'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $technician['email'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $technician['phone'] }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">Experience: {{ $technician['experience'] }} years</div>
                                    <div class="text-sm text-gray-500 truncate">{{ Str::limit($technician['bio'], 50) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($technician['skills'] as $skill)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                    <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($technician['fields_of_work'] as $field)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                {{ $field }}
                                            </span>
                            @endforeach
                                    </div>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                    <a href="{{ route('admin.technicians.view', $technician['id']) }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                            👁️ View
                        </a>
                                    <form action="{{ route('admin.technicians.toggle-status', $technician['id']) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                                        <button type="submit" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                             ✅ Accept
                            </button>
                        </form>
                    </td>
                </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12">
                                    <div class="flex flex-col items-center justify-center min-h-[400px]">
                                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-1">No Rejected Technicians</h3>
                                        <p class="text-gray-500">There are currently no rejected technician requests.</p>
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
@endsection
