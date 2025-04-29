@extends('admin.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">Technician Registration Requests</h2>

    <div class="space-y-6">
        @php
            $requests = [
                [
                    'name' => 'Ali Raza',
                    'email' => 'ali.raza@mail.com',
                    'phone' => '+92 300 1112233',
                    'profession' => 'Electrician',
                    'fields_of_work' => 'Electrical wiring, Lighting installation, Circuit repair',
                    'services_offered' => 'Home wiring, Electrical appliance installation'
                ],
                [
                    'name' => 'Zain Malik',
                    'email' => 'zain.malik@mail.com',
                    'phone' => '+92 300 4445566',
                    'profession' => 'Plumber',
                    'fields_of_work' => 'Pipe installation, Leak repairs, Drain cleaning',
                    'services_offered' => 'Bathroom plumbing, Kitchen plumbing'
                ],
                [
                    'name' => 'Hassan Tariq',
                    'email' => 'hassan.tariq@mail.com',
                    'phone' => '+92 300 7778899',
                    'profession' => 'Carpenter',
                    'fields_of_work' => 'Woodworking, Furniture making, Cabinetry',
                    'services_offered' => 'Custom furniture, Home repairs'
                ],
                [
                    'name' => 'Sana Iqbal',
                    'email' => 'sana.iqbal@mail.com',
                    'phone' => '+92 300 1010101',
                    'profession' => 'AC Technician',
                    'fields_of_work' => 'Installation, Repair, Maintenance',
                    'services_offered' => 'AC installation, Air conditioning maintenance'
                ],
                [
                    'name' => 'Usman Ghani',
                    'email' => 'usman.ghani@mail.com',
                    'phone' => '+92 300 2020202',
                    'profession' => 'Painter',
                    'fields_of_work' => 'Interior and exterior painting, Wall treatments',
                    'services_offered' => 'House painting, Office painting'
                ]
            ];
        @endphp

        @foreach ($requests as $request)
        <div class="w-full bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition duration-300 cursor-pointer">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                <!-- Technician Info (Full Width Text) -->
                <div class="flex w-full justify-between items-start gap-4">
                    <div class="bg-blue-100 text-blue-600 rounded-full w-12 h-12 flex items-center justify-center text-xl font-bold">
                        {{ strtoupper(substr($request['name'], 0, 1)) }}
                    </div>
                    <div class="w-full">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $request['name'] }}</h3>
                        <p class="text-gray-600 text-sm"><strong>Email:</strong> {{ $request['email'] }}</p>
                        <p class="text-gray-600 text-sm"><strong>Phone:</strong> {{ $request['phone'] }}</p>
                        <p class="text-gray-600 text-sm"><strong>Profession:</strong> {{ $request['profession'] }}</p>
                        <p class="text-gray-600 text-sm"><strong>Fields of Work:</strong> {{ $request['fields_of_work'] }}</p>
                        <p class="text-gray-600 text-sm"><strong>Services Offered:</strong> {{ $request['services_offered'] }}</p>
                    </div>
                </div>

                <!-- Action Buttons (Aligned to the Right) -->
                <div class="mt-4 md:mt-0 flex gap-3 justify-end w-full">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition-transform transform hover:scale-105">
                        🔍 View
                    </button>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition-transform transform hover:scale-105">
                        ✅ Accept
                    </button>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition-transform transform hover:scale-105">
                        ❌ Reject
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
