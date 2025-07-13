<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Maintera Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/tailwind.output.css') }}" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="js/init-alpine.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
    <script src="js/charts-lines.js" defer></script>
    <script src="js/charts-pie.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/sweet-alert-utils.js') }}"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen" x-data="{ isSideMenuOpen: false }">
        @include('admin.sidebar')
        <div class="flex flex-col flex-1">
            @include('admin.topbar')
            <main class="h-full overflow-y-auto bg-gray-50 p-0">
                @yield('content')
            </main>
        </div>
        
        <!-- Support Button -->
        <x-support-button />
    </div>
    
    <!-- SweetAlert session handler -->
    <x-alerts.sweet-alert />
    <x-toast-messages />
</body>
</html>
