@extends('admin.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-4xl md:text-5xl font-extrabold text-indigo-800 tracking-tight text-center mb-12 leading-tight">
        <span class="m-2 p-3 inline-block align-middle mr-2">🔧</span>
        <span class="inline-block align-middle">Manage Technician Services & Categories</span>
    </h1>
    

    {{-- 🌟 Add Category Section --}}
    <div class="bg-white rounded-2xl border-l-4 border-blue-500 shadow-lg p-6 mb-12">
        <h4 class="text-2xl font-semibold text-blue-700 mb-4">📁 Add New Category</h4>
        <form action="{{ route('admin.services.storeCategory') }}" method="POST" class="flex gap-4 items-center">
            @csrf
            <input type="text" name="category_name" placeholder="e.g. Electrical, Plumbing" class="flex-1 border border-gray-300 rounded-lg p-3 shadow-sm focus:ring focus:ring-blue-200" required> 
            <button type="submit" class=" m-2 p-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition-transform transform hover:scale-105">
                ➕ Add Category
            </button>
        </form>
    </div>

    {{-- 🔧 Add Service Section --}}
    <div class="bg-white rounded-2xl border-l-4 border-green-500 shadow-lg p-6 mb-12">
        <h3 class="text-2xl font-semibold text-green-700 mb-4">🛠️ Add New Service</h3>
        <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Category</label>
                <select name="category_id" class="block w-full border border-gray-300 rounded-lg p-3 shadow-sm focus:ring focus:ring-green-200" required>
                    <option value="">-- Choose Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Service Name</label>
                <input type="text" name="service_name" class="block w-full border border-gray-300 rounded-lg p-3 shadow-sm focus:ring focus:ring-green-200" placeholder="e.g. Circuit Repair">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Service Description</label>
                <textarea name="service_description" rows="3" class="block w-full border border-gray-300 rounded-lg p-3 shadow-sm focus:ring focus:ring-green-200" placeholder="Short description..."></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition-transform transform hover:scale-105">
                    ➕ Add Service
                </button>
            </div>
        </form>
    </div>

    {{-- 📋 Services Table Section --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-lg p-6">
        <h3 class="text-2xl font-semibold text-indigo-800 mb-6">📋 List of All Services</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left text-gray-700">
                <thead class="bg-indigo-50">
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Service Name</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Category</th>
                        <th class="px-4 py-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $index => $service)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 font-medium text-gray-900">{{ $service->name }}</td>
                            <td class="px-4 py-2">{{ $service->description }}</td>
                            <td class="px-4 py-2 text-sm">{{ $service->category->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2 text-right">
                                <form action="{{ route('admin.services.delete', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition-transform transform hover:scale-105">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">No services found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-6">
                {{ $services->links() }}
            </div>
            
        </div>

      
    </div>
</div>
@endsection
