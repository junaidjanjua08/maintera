@extends('admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 px-6 py-10">
    <h2 class="text-4xl font-extrabold text-blue-700 mb-12 text-center tracking-wide drop-shadow">
        🚀 Technician Registration Requests
    </h2>

    <div class="space-y-8 max-w-5xl mx-auto">
        @forelse ($technicians as $technician)
        <div class="w-full bg-white rounded-2xl border border-blue-200 shadow-xl p-6 hover:scale-[1.01] hover:shadow-2xl transition-all duration-300 cursor-pointer">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-6">
                <!-- Technician Info -->
                <div class="flex gap-4 items-start w-full md:w-2/3">
                    <div class="bg-blue-100 text-blue-600 rounded-full w-14 h-14 flex items-center justify-center text-2xl font-bold shadow-md">
                        {{ strtoupper(substr($technician->name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">{{ $technician->name }}</h3>
                        <div class="text-sm space-y-1 mt-2 text-gray-700">
                            <p><strong>Email:</strong> {{ $technician->email ?? 'N/A' }}</p>
                            <p><strong>Phone:</strong> {{ $technician->phone ?? 'N/A' }}</p>
                            <p><strong>Profession:</strong> {{ $technician->profession ?? 'N/A' }}</p>
                            <p><strong>Fields of Work:</strong> {{ $technician->fields_of_work ?? 'N/A' }}</p>
                            <p><strong>Services Offered:</strong> {{ $technician->services_offered ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 md:w-1/3 justify-end">
                    <a href=""
                        class="flex items-center justify-center gap-2 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold px-5 py-2 rounded-lg shadow hover:shadow-lg transition">
                        🔍 View
                    </a>

                    <form method="POST" action="{{ route('admin.technicians.accept', $technician->id) }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-5 py-2 rounded-lg shadow hover:shadow-lg transition">
                            ✅ Accept
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.technicians.reject', $technician->id) }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-2 rounded-lg shadow hover:shadow-lg transition">
                            ❌ Reject
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
            <p class="text-gray-500 text-center text-xl mt-12">No pending technician registration requests.</p>
        @endforelse
    </div>
</div>
@endsection
