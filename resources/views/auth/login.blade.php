<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Maintera</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .form-container {
    z-index: 1;
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
    width: 100%;
    max-width: 400px;
    position: relative;
}

body {
    background-color: #f0f2f5;
    height: 100vh;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}




        /* Animated Background Elements */
        .gear {
            position: absolute;
            fill: #6b7280; /* Gray color for gears */
            opacity: 0.1;
        }

        .gear1 {
            top: 10%;
            left: 15%;
            width: 120px;
            animation: rotate 8s linear infinite;
        }

        .gear2 {
            bottom: 15%;
            right: 20%;
            width: 150px;
            animation: rotate-reverse 10s linear infinite;
        }

        /* Rotating animation */
        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes rotate-reverse {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(-360deg);
            }
        }

    
    </style>
</head>
<body>

    <!-- Background SVG gears -->
    <svg class="gear gear1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
        <path d="M63,38V26H54.77A23.9,23.9,0,0,0,50.11,17L56,11.13,52.87,8,47,13.89a23.9,23.9,0,0,0-9-4.66V1H26V9.23a23.9,23.9,0,0,0-9,4.66L11.13,8,8,11.13,13.89,17a23.9,23.9,0,0,0-4.66,9H1V38H9.23a23.9,23.9,0,0,0,4.66,9L8,52.87,11.13,56,17,50.11a23.9,23.9,0,0,0,9,4.66V63H38V54.77a23.9,23.9,0,0,0,9-4.66L52.87,56,56,52.87,50.11,47a23.9,23.9,0,0,0,4.66-9Z"/>
    </svg>

    <svg class="gear gear2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
        <path d="M63,38V26H54.77A23.9,23.9,0,0,0,50.11,17L56,11.13,52.87,8,47,13.89a23.9,23.9,0,0,0-9-4.66V1H26V9.23a23.9,23.9,0,0,0-9,4.66L11.13,8,8,11.13,13.89,17a23.9,23.9,0,0,0-4.66,9H1V38H9.23a23.9,23.9,0,0,0,4.66,9L8,52.87,11.13,56,17,50.11a23.9,23.9,0,0,0,9,4.66V63H38V54.77a23.9,23.9,0,0,0,9-4.66L52.87,56,56,52.87,50.11,47a23.9,23.9,0,0,0,4.66-9Z"/>
    </svg>

    <!-- Login Form -->
    <div class="form-container">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <img src="{{ asset('path_to_logo/logo.png') }}" alt="Maintera Logo" class="h-14 w-auto">
        </div>

        <!-- Login Form -->
        <form class="space-y-4" method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email Address -->
           
            <input type="hidden" name="role" value="{{ request('role') ?? 'customer' }}">

            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="block w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="you@example.com" required autofocus autocomplete="username" value="{{ old('email') }}">
                @error('email')
                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="block w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="••••••••" required autocomplete="current-password">
                @error('password')
                <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center text-sm">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2">Remember Me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">Forgot Password?</a>
                @endif
            </div>

            <!-- Login Button -->
            <div>
                <button type="submit" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg text-sm px-5 py-3 text-center focus:ring-4 focus:outline-none focus:ring-indigo-300 transition ease-in-out duration-150">
                    Log in
                </button>
            </div>
        </form>

        <!-- Registration Link -->
        <p class="text-sm text-center text-gray-600 mt-6">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Sign Up</a>
        </p>
    </div>

</body>
</html>
