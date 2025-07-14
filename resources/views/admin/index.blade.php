@extends('admin.app')
@section('content')
<div class="container px-6 mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">

    <!-- Total Customers -->
    <a class="block p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 cursor-pointer">
        <div class="flex items-center gap-4">
            <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a4 4 0 00-5-4m-6 6h6M9 20H4v-2a4 4 0 015-4m6-6a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-gray-600 text-sm font-semibold">Total Customers</h2>
                <p class="text-2xl font-bold text-blue-600">{{ $customers ? $customers : '0' }}</p>
            </div>
        </div>
    </a>

    <!-- Total Technicians -->
    <a class="block p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 cursor-pointer">
        <div class="flex items-center gap-4">
            <div class="bg-green-100 text-green-600 p-3 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.232 5.232a3 3 0 01-4.264 4.264m6.586 1.414a4.978 4.978 0 00-1.414-6.586m2.121 2.121a4.978 4.978 0 01-6.586-1.414M16 21h2a2 2 0 002-2v-2l-3-3-3 3v2a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-gray-600 text-sm font-semibold">Total Technicians</h2>
                <p class="text-2xl font-bold text-green-600">{{ $technicians ? $technicians : '0' }}</p>
            </div>
        </div>
    </a>

    <!-- Technician Registration Requests -->
    <a class="block p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 cursor-pointer">
        <div class="flex items-center gap-4">
            <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4M7 4h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-gray-600 text-sm font-semibold">Tech Reg. Requests</h2>
                <p class="text-2xl font-bold text-yellow-600">{{ $tech_requests ? $tech_requests : '0'  }}</p>
            </div>
        </div>
    </a>

   

 

    <!-- Support Requests -->
    <a href="{{ route('admin.support-requests.index') }}" class="block p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 cursor-pointer">
        <div class="flex items-center gap-4">
            <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-gray-600 text-sm font-semibold">Support Requests</h2>
                <p class="text-2xl font-bold text-indigo-600">{{ $supportRequests ?? '0' }}</p>
            </div>
        </div>
    </a>

</div>
@endsection
