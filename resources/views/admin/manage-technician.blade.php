@extends('admin.app')

@section('content')
<div class="container mx-auto px-6 py-10">
    <!-- Heading -->
    <div class="text-center mb-12">
        <h2 class="text-5xl font-extrabold text-white mb-4 tracking-tight leading-tight">
            🛠️ Manage Technicians
        </h2>
        <p class="text-xl text-gray-400 max-w-3xl mx-auto">Enable/disable technician accounts and manage their access.</p>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200">
        <table class="min-w-full table-auto">
            <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Sr. No.</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Services</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-gray-700 text-sm">
                @php
                    $technicians = [
                        ['id' => 1, 'name' => 'Ali Raza', 'email' => 'ali.raza@mail.com', 'services' => ['Home wiring'], 'status' => true],
                        ['id' => 2, 'name' => 'Sana Iqbal', 'email' => 'sana.iqbal@mail.com', 'services' => ['AC installation', 'Maintenance'], 'status' => false],
                    ];
                @endphp

                @foreach ($technicians as $index => $technician)
                <tr class="hover:bg-indigo-50 transition duration-300">
                    <td class="px-6 py-4 font-semibold">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-medium">{{ $technician['name'] }}</td>
                    <td class="px-6 py-4">{{ $technician['email'] }}</td>
                    <td class="px-6 py-4">
                        <ul class="list-disc list-inside">
                            @foreach ($technician['services'] as $service)
                                <li>{{ $service }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="#" method="POST">
                            @csrf
                            @method('PATCH')
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" {{ $technician['status'] ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 rounded-full peer peer-checked:bg-green-500 transition duration-300"></div>
                            </label>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form action="#" method="POST" onsubmit="return confirm('Are you sure you want to delete this technician?');">
                            @csrf
                            @method('DELETE')
                            <button class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow-md text-sm transition-all duration-300">
                                🗑️ Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
