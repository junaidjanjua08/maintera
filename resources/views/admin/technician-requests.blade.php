@extends('admin.app')

@section('content')
<div class="min-h-screen bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Enhanced Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Pending Technician Requests</h2>
                    <p class="text-gray-600">Review and approve new technician applications</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg">
                        <span class="text-sm font-medium">{{ count($technicians) }} Pending Applications</span>
                    </div>
                    <button onclick="exportToCSV()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Export</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Search technicians by name, email, or skills..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                      
                    </div>
                </div>
                <div class="flex gap-2">
                    <select id="experienceFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Experience</option>
                        <option value="0-2">0-2 years</option>
                        <option value="3-5">3-5 years</option>
                        <option value="5+">5+ years</option>
                    </select>
                    <select id="occupationFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Occupations</option>
                        <option value="Plumber">Plumber</option>
                        <option value="Electrician">Electrician</option>
                        <option value="Carpenter">Carpenter</option>
                        <option value="Painter">Painter</option>
                        <option value="Cleaner">Cleaner</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Enhanced Main Table -->
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
                                    Status
                                </th>
                                <th scope="col" class="w-1/6 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="techniciansTableBody">
        @forelse ($technicians as $technician)
                            <tr class="hover:bg-gray-50 transition-colors duration-150 technician-row" 
                                data-name="{{ strtolower($technician->user->name) }}" 
                                data-email="{{ strtolower($technician->user->email) }}" 
                                data-occupation="{{ strtolower($technician->occupation) }}" 
                                data-experience="{{ $technician->experience }}"
                                data-skills="{{ strtolower(implode(' ', $technician->skills ?? [])) }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            @if($technician->profile_image)
                                                <img class="h-12 w-12 rounded-full object-cover" src="{{ asset($technician->profile_image) }}" alt="{{ $technician->user->name }}">
                                            @else
                                            @php
                                                    $colors = ['from-blue-500 to-purple-600', 'from-green-500 to-teal-600', 'from-purple-500 to-pink-600', 'from-orange-500 to-red-600', 'from-indigo-500 to-blue-600', 'from-pink-500 to-rose-600'];
                                                $colorIndex = ord(strtolower(substr($technician->user->name, 0, 1))) % count($colors);
                                                $avatarColor = $colors[$colorIndex];
                                            @endphp
                                                <div class="h-12 w-12 rounded-full bg-gradient-to-r {{ $avatarColor }} flex items-center justify-center">
                                                    <span class="text-white font-semibold text-sm">{{ substr($technician->user->name, 0, 2) }}</span>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $technician->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $technician->occupation ?? 'N/A' }}</div>
                                            <div class="flex items-center mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Pending
                                                </span>
                        </div>
                    </div>
                </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-medium">{{ $technician->user->email }}</div>
                                    <div class="text-sm text-gray-500 flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        {{ $technician->phone ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-medium">{{ $technician->experience ?? 'N/A' }} years experience</div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        @if($technician->bio)
                                            <div class="truncate max-w-xs" title="{{ $technician->bio }}">
                                                {{ Str::limit($technician->bio, 60) }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">No bio available</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @if($technician->skills && count($technician->skills) > 0)
                                            @foreach(array_slice($technician->skills, 0, 3) as $skill)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $skill }}
                                                </span>
                                            @endforeach
                                            @if(count($technician->skills) > 3)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                                    +{{ count($technician->skills) - 3 }} more
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-400 italic text-xs">No skills listed</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            Inactive
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                    <div class="flex flex-col space-y-2">
                                        <a href="{{ route('admin.technicians.view', $technician->user) }}" 
                                           class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-2 rounded-lg shadow-sm transition-all duration-200 transform hover:scale-105">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View
                                        </a>
                                        <form action="{{ route('admin.technicians.toggle-status', $technician->user) }}" method="POST" class="inline">
                        @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to activate this technician?')"
                                                    class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white text-sm px-3 py-2 rounded-lg shadow-sm transition-all duration-200 transform hover:scale-105">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Activate
                                            </button>
                    </form>
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

<script>
// Search and Filter Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const experienceFilter = document.getElementById('experienceFilter');
    const occupationFilter = document.getElementById('occupationFilter');
    const tableBody = document.getElementById('techniciansTableBody');
    const rows = tableBody.querySelectorAll('.technician-row');

    function filterTechnicians() {
        const searchTerm = searchInput.value.toLowerCase();
        const experienceValue = experienceFilter.value;
        const occupationValue = occupationFilter.value;

        rows.forEach(row => {
            const name = row.dataset.name;
            const email = row.dataset.email;
            const occupation = row.dataset.occupation;
            const experience = parseInt(row.dataset.experience) || 0;
            const skills = row.dataset.skills;

            let showRow = true;

            // Search filter
            if (searchTerm && !name.includes(searchTerm) && !email.includes(searchTerm) && !skills.includes(searchTerm)) {
                showRow = false;
            }

            // Experience filter
            if (experienceValue) {
                if (experienceValue === '0-2' && (experience < 0 || experience > 2)) {
                    showRow = false;
                } else if (experienceValue === '3-5' && (experience < 3 || experience > 5)) {
                    showRow = false;
                } else if (experienceValue === '5+' && experience < 5) {
                    showRow = false;
                }
            }

            // Occupation filter
            if (occupationValue && !occupation.includes(occupationValue.toLowerCase())) {
                showRow = false;
            }

            row.style.display = showRow ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTechnicians);
    experienceFilter.addEventListener('change', filterTechnicians);
    occupationFilter.addEventListener('change', filterTechnicians);
});

// CSV Export Function
function exportToCSV() {
    const table = document.querySelector('table');
    const rows = table.querySelectorAll('tr');
    let csv = [];
    
    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const rowData = [];
        cols.forEach(col => {
            // Get text content and clean it
            let text = col.textContent.trim();
            // Remove extra whitespace and newlines
            text = text.replace(/\s+/g, ' ');
            // Escape quotes and wrap in quotes if contains comma
            if (text.includes(',') || text.includes('"')) {
                text = '"' + text.replace(/"/g, '""') + '"';
            }
            rowData.push(text);
        });
        csv.push(rowData.join(','));
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', 'pending_technicians.csv');
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
@endsection
