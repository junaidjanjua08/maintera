@extends('admin.app')

@section('content')
<div class="container mx-auto px-6 py-10">
        <!-- Heading Section -->
    <div class="text-center mb-12">
        <h2 class="text-5xl font-extrabold text-white mb-4 tracking-tight leading-tight">
            ✅ Accepted Technicians
        </h2>
        <p class="text-xl text-gray-400 max-w-3xl mx-auto">A list of all technicians who have been accepted for service tasks, with their details and available services.</p>
    </div>

    <!-- Table Section -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200">
        <table class="min-w-full table-auto">
            <thead class="bg-gradient-to-r from-green-600 to-green-500 text-white">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Technician Name</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Services</th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white text-sm text-gray-700 divide-y divide-gray-200">
                @php
                    $technicians = [
                        ['id' => 1, 'name' => 'Ali Raza', 'email' => 'ali.raza@mail.com', 'services' => ['Home wiring', 'Appliance installation']],
                        ['id' => 2, 'name' => 'Sana Iqbal', 'email' => 'sana.iqbal@mail.com', 'services' => ['AC installation', 'Maintenance']],
                    ];
                @endphp
                @foreach ($technicians as $technician)
                <tr class="hover:bg-green-50 transition-all duration-300 ease-in-out transform hover:scale-105">
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $technician['id'] }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $technician['name'] }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $technician['email'] }}</td>
                    <td class="px-6 py-4">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($technician['services'] as $service)
                                <li>{{ $service }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                        <a href="{{-- route('admin.technicians.profile', ['id' => $technician['id']]) --}}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                            👁️ View
                        </a>
                        <form action="#" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105">
                                ❌ Reject
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
