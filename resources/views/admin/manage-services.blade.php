@extends('admin.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h2 class="text-4xl font-bold text-indigo-900 mb-10">🔧 Manage Technician Services & Categories</h2>

    {{-- 🌟 Add Category Section --}}
    <div class="bg-white rounded-2xl border-l-4 border-blue-500 shadow-lg p-6 mb-12">
        <h3 class="text-2xl font-semibold text-blue-700 mb-4">📁 Add New Category</h3>
        <form action="#" method="POST" class="flex gap-4 items-center">
            @csrf
            <input type="text" name="category_name" placeholder="e.g. Electrical, Plumbing" class="flex-1 border border-gray-300 rounded-lg p-3 shadow-sm focus:ring focus:ring-blue-200" required>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition-transform transform hover:scale-105">
                ➕ Add Category
            </button>
        </form>
    </div>

    {{-- 🔧 Add Service Section --}}
    <div class="bg-white rounded-2xl border-l-4 border-green-500 shadow-lg p-6 mb-12">
        <h3 class="text-2xl font-semibold text-green-700 mb-4">🛠️ Add New Service</h3>
        <form action="#" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Category</label>
                <select name="category_id" class="block w-full border border-gray-300 rounded-lg p-3 shadow-sm focus:ring focus:ring-green-200">
                    <option value="">-- Choose Category --</option>
                    <option value="1">Electrical</option>
                    <option value="2">Plumbing</option>
                    <option value="3">AC Repair</option>
                    {{-- Dynamic options from DB --}}
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
                    @php
                        $services = [
                            ['id' => 1, 'name' => 'Home Wiring', 'description' => 'Complete home wiring service', 'category' => 'Electrical'],
                            ['id' => 2, 'name' => 'Drain Cleaning', 'description' => 'Unclog drains and pipes', 'category' => 'Plumbing'],
                            ['id' => 3, 'name' => 'AC Tune-up', 'description' => 'Full service AC inspection', 'category' => 'AC Repair'],
                        ];
                    @endphp
                    @foreach ($services as $index => $service)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 font-medium text-gray-900">{{ $service['name'] }}</td>
                        <td class="px-4 py-2">{{ $service['description'] }}</td>
                        <td class="px-4 py-2 text-sm">{{ $service['category'] }}</td>
                        <td class="px-4 py-2 text-right">
                            <form action="#" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition-transform transform hover:scale-105">
                                    🗑️ Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination Placeholder --}}
        <div class="mt-6 flex justify-end">
            <nav class="inline-flex rounded-md shadow-sm">
                <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-l">«</button>
                <button class="px-3 py-1 bg-blue-500 text-white">1</button>
                <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200">2</button>
                <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200">3</button>
                <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-r">»</button>
            </nav>
        </div>
    </div>
</div>
@endsection
