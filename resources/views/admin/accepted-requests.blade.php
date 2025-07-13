@extends('admin.app')

@section('content')
<div class="min-h-screen bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Enhanced Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Accepted Technicians</h2>
                    <p class="text-gray-600">Manage and monitor your approved technician accounts</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                        <span class="text-sm font-medium">{{ count($technicians) }} Active Technicians</span>
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
                        </svg>
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
                                    Fields of Work
                                </th>
                                <th scope="col" class="w-1/6 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="techniciansTableBody">
                            @forelse ($technicians as $technician)
                            <tr class="hover:bg-gray-50 transition-colors duration-150 technician-row" 
                                data-name="{{ strtolower($technician['name']) }}" 
                                data-email="{{ strtolower($technician['email']) }}" 
                                data-occupation="{{ strtolower($technician['occupation']) }}" 
                                data-experience="{{ $technician['experience'] }}"
                                data-skills="{{ strtolower(implode(' ', $technician['skills'])) }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            @if($technician['profile_image'])
                                                <img class="h-12 w-12 rounded-full object-cover" src="{{ asset($technician['profile_image']) }}" alt="{{ $technician['name'] }}">
                                            @else
                                                <div class="h-12 w-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                                    <span class="text-white font-semibold text-sm">{{ substr($technician['name'], 0, 2) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $technician['name'] }}</div>
                                            <div class="text-sm text-gray-500">{{ $technician['occupation'] }}</div>
                                            <div class="flex items-center mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Active
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-medium">{{ $technician['email'] }}</div>
                                    <div class="text-sm text-gray-500 flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        {{ $technician['phone'] }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-medium">{{ $technician['experience'] }} years experience</div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        @if($technician['bio'])
                                            <div class="truncate max-w-xs" title="{{ $technician['bio'] }}">
                                                {{ Str::limit($technician['bio'], 60) }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">No bio available</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @if(count($technician['skills']) > 0)
                                            @foreach(array_slice($technician['skills'], 0, 3) as $skill)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $skill }}
                                                </span>
                                            @endforeach
                                            @if(count($technician['skills']) > 3)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                                    +{{ count($technician['skills']) - 3 }} more
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-400 italic text-xs">No skills listed</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @if(count($technician['fields_of_work']) > 0)
                                            @foreach(array_slice($technician['fields_of_work'], 0, 2) as $field)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $field }}
                                                </span>
                                            @endforeach
                                            @if(count($technician['fields_of_work']) > 2)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                                    +{{ count($technician['fields_of_work']) - 2 }} more
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-400 italic text-xs">No fields listed</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                    <div class="flex flex-col space-y-2">
                                        <a href="{{ route('admin.technicians.view', $technician['id']) }}" 
                                           class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-2 rounded-lg shadow-sm transition-all duration-200 transform hover:scale-105">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View
                                        </a>
                                        <form action="{{ route('admin.technicians.toggle-status', $technician['id']) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to deactivate this technician?')"
                                                    class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-2 rounded-lg shadow-sm transition-all duration-200 transform hover:scale-105">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                                </svg>
                                                Deactivate
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
                                        <h3 class="text-lg font-medium text-gray-900 mb-1">No Accepted Technicians</h3>
                                        <p class="text-gray-500">There are currently no accepted technician requests.</p>
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

<!-- Enhanced JavaScript for Search and Filter Functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const experienceFilter = document.getElementById('experienceFilter');
    const occupationFilter = document.getElementById('occupationFilter');
    const technicianRows = document.querySelectorAll('.technician-row');

    function filterTechnicians() {
        const searchTerm = searchInput.value.toLowerCase();
        const experienceValue = experienceFilter.value;
        const occupationValue = occupationFilter.value.toLowerCase();

        technicianRows.forEach(row => {
            const name = row.getAttribute('data-name');
            const email = row.getAttribute('data-email');
            const occupation = row.getAttribute('data-occupation');
            const experience = parseInt(row.getAttribute('data-experience'));
            const skills = row.getAttribute('data-skills');

            let showRow = true;

            // Search filter
            if (searchTerm) {
                const matchesSearch = name.includes(searchTerm) || 
                                    email.includes(searchTerm) || 
                                    skills.includes(searchTerm);
                if (!matchesSearch) showRow = false;
            }

            // Experience filter
            if (experienceValue) {
                let experienceMatch = false;
                switch(experienceValue) {
                    case '0-2':
                        experienceMatch = experience >= 0 && experience <= 2;
                        break;
                    case '3-5':
                        experienceMatch = experience >= 3 && experience <= 5;
                        break;
                    case '5+':
                        experienceMatch = experience >= 5;
                        break;
                }
                if (!experienceMatch) showRow = false;
            }

            // Occupation filter
            if (occupationValue) {
                if (!occupation.includes(occupationValue)) {
                    showRow = false;
                }
            }

            // Show/hide row
            row.style.display = showRow ? '' : 'none';
        });

        // Update visible count
        updateVisibleCount();
    }

    function updateVisibleCount() {
        const visibleRows = document.querySelectorAll('.technician-row:not([style*="display: none"])');
        const countElement = document.querySelector('.bg-green-100 span');
        if (countElement) {
            countElement.textContent = `${visibleRows.length} Active Technicians`;
        }
    }

    // Event listeners
    searchInput.addEventListener('input', filterTechnicians);
    experienceFilter.addEventListener('change', filterTechnicians);
    occupationFilter.addEventListener('change', filterTechnicians);

    // Export functionality
    window.exportToCSV = function() {
        const visibleRows = document.querySelectorAll('.technician-row:not([style*="display: none"])');
        let csvContent = "Name,Email,Occupation,Experience,Phone,Skills,Fields of Work\n";
        
        visibleRows.forEach(row => {
            const name = row.querySelector('.text-gray-900').textContent.trim();
            const email = row.querySelector('.text-gray-900.font-medium').textContent.trim();
            const occupation = row.querySelector('.text-gray-500').textContent.trim();
            const experience = row.getAttribute('data-experience');
            const phone = row.querySelector('.text-gray-500.flex').textContent.trim();
            const skills = row.getAttribute('data-skills');
            const fields = row.querySelectorAll('.bg-green-100.text-green-800');
            const fieldsText = Array.from(fields).map(field => field.textContent.trim()).join('; ');
            
            csvContent += `"${name}","${email}","${occupation}","${experience}","${phone}","${skills}","${fieldsText}"\n`;
        });

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', 'accepted_technicians.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };

    // Initialize count
    updateVisibleCount();
});
</script>
@endsection
