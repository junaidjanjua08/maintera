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

    <!-- Customer Queries -->
    <a class="block p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 cursor-pointer">
        <div class="flex items-center gap-4">
            <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 10h.01M12 10h.01M16 10h.01M21 12c0-4.418-4.03-8-9-8S3 7.582 3 12c0 1.837.633 3.53 1.7 4.9L4 21l4.1-1.7A9.978 9.978 0 0012 20c4.97 0 9-3.582 9-8z" />
                </svg>
            </div>
            <div>
                <h2 class="text-gray-600 text-sm font-semibold">Customer Queries</h2>
                <p class="text-2xl font-bold text-purple-600">19</p>
            </div>
        </div>
    </a>

    <!-- Technician Queries -->
    <a class="block p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 cursor-pointer">
        <div class="flex items-center gap-4">
            <div class="bg-red-100 text-red-600 p-3 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18.364 5.636a9 9 0 11-12.728 0m12.728 0A9 9 0 005.636 18.364M18.364 5.636L12 12" />
                </svg>
            </div>
            <div>
                <h2 class="text-gray-600 text-sm font-semibold">Technician Queries</h2>
                <p class="text-2xl font-bold text-red-600">11</p>
            </div>
        </div>
    </a>

</div>
@endsection
