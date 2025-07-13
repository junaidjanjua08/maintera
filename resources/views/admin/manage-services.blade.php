@extends('admin.app')

@section('content')
<div class="min-h-screen bg-gray-50 px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Enhanced Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Manage Services & Categories</h2>
                    <p class="text-gray-600">Create and manage service categories and individual services</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">
                        <span class="text-sm font-medium">{{ $services->total() }} Total Services</span>
                    </div>
                    <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                        <span class="text-sm font-medium">{{ count($categories) }} Categories</span>
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

    

        <div class="mb-8 bg-white rounded-lg shadow-sm">
            <div class="px-2 py-4 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800">Add category and service</h3>
            </div>
        <!-- Simple Add Category -->
        <div class="mb-8">
            <form action="{{ route('admin.services.storeCategory') }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end">
            @csrf
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                    <input type="text" name="category_name" placeholder="e.g. Electrical, Plumbing" 
                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                </div>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">Add Category</button>
        </form>
    </div>

        <!-- Simple Add Service -->
        <div class="mb-8">
            <form action="{{ route('admin.services.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf
            <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                        <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Service Name</label>
                    <input type="text" name="service_name" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" placeholder="e.g. Circuit Repair" required>
            </div>
            <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <input name="service_description" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" placeholder="Short description...">
            </div>
                <div class="md:col-span-3 flex justify-end mt-2">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">Add Service</button>
            </div>
        </form>
    </div>
        </div>

        <!-- Simple Search/Filter Bar -->
        <div class="mb-8 bg-white rounded-lg shadow-sm">
        <div class="px-2 py-4 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800">Search service</h3>
        </div>
       
           
            <div class="flex flex-col md:flex-row gap-4">
                <input type="text" id="searchInput" placeholder="Search services..." 
                       class="flex-1 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                <select id="categoryFilter" class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- Enhanced Services Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800">All Services</h3>
            </div>
        <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Service Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                    </tr>
                </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="servicesTableBody">
                    @forelse ($services as $index => $service)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 service-row" 
                            data-name="{{ strtolower($service->name) }}" 
                            data-description="{{ strtolower($service->description) }}" 
                            data-category="{{ strtolower($service->category->name ?? '') }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $service->name }}</div>
                                <div class="text-xs text-gray-500">ID: {{ $service->id }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    @if($service->description)
                                        <div class="truncate max-w-xs" title="{{ $service->description }}">
                                            {{ Str::limit($service->description, 60) }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">No description</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $service->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <form action="{{ route('admin.services.delete', $service->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this service? This action cannot be undone.')"
                                            class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-2 rounded-lg shadow-sm transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12">
                                <div class="flex flex-col items-center justify-center min-h-[200px]">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Services Found</h3>
                                    <p class="text-gray-500">Start by adding your first service above.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
            @if($services->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $services->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
// Search and Filter Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const tableBody = document.getElementById('servicesTableBody');
    const rows = tableBody.querySelectorAll('.service-row');

    function filterServices() {
        const searchTerm = searchInput.value.toLowerCase();
        const categoryValue = categoryFilter.value.toLowerCase();

        rows.forEach(row => {
            const name = row.dataset.name;
            const description = row.dataset.description;
            const category = row.dataset.category;

            let showRow = true;

            // Search filter
            if (searchTerm && !name.includes(searchTerm) && !description.includes(searchTerm)) {
                showRow = false;
            }

            // Category filter
            if (categoryValue && category !== categoryValue) {
                showRow = false;
            }

            row.style.display = showRow ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterServices);
    categoryFilter.addEventListener('change', filterServices);
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
    link.setAttribute('download', 'services.csv');
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
@endsection
