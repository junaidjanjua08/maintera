<!DOCTYPE html>
<html lang="en">

<head>
  @include('technician.partials.head')
  <title>Sign In | Dash Ui - Bootstrap 5 Admin Dashboard Template</title>
</head>

<body>
  <!-- container -->
  <div class="container d-flex flex-column">
    <div class="row align-items-center justify-content-center g-0
        min-vh-100">
      <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
        <!-- Card -->
        <div class="card smooth-shadow-md">
          <!-- Card body -->
          <div class="card-body p-6">
            <div class="mb-4">
              <a href="../index.html"><img src="../assets/images/brand/logo/logo-primary.svg" class="mb-2" alt=""></a>
              <p class="mb-6">Please enter your user information.</p>
            </div>
            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
              @csrf
      
              <!-- Email Address -->
              <div>
                  <x-input-label for="email" :value="__('Email')" />
                  <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                  <x-input-error :messages="$errors->get('email')" class="mt-2" />
              </div>
      
              <!-- Password -->
              <div class="mt-4">
                  <x-input-label for="password" :value="__('Password')" />
      
                  <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password" />
      
                  <x-input-error :messages="$errors->get('password')" class="mt-2" />
              </div>
      
              <!-- Remember Me -->
              <div class="block mt-4">
                  <label for="remember_me" class="inline-flex items-center">
                      <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                      <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                  </label>
              </div>
      
              <div class="flex items-center justify-end mt-4">
                  @if (Route::has('password.request'))
                      <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                          {{ __('Forgot your password?') }}
                      </a>
                  @endif
      
                  <x-primary-button class="ms-3">
                      {{ __('Log in') }}
                  </x-primary-button>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Scripts -->
  @include('technician.partials.scripts')
</body>

</html>