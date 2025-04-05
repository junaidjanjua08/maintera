<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'role' => ['required', 'in:customer,technician'], // Validate role
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        // Ensure user is not rate-limited
        $this->ensureIsNotRateLimited();
    
        // Retrieve credentials from the request
        $credentials = $this->only('email', 'password');

        // Attempt to authenticate the user with the given credentials
        if (Auth::attempt($credentials, $this->boolean('remember'))) {
            $user = Auth::user();

            // Check if the authenticated user has the correct role
            if ($user->role !== $this->input('role')) {
                // If the role doesn't match, log the user out
                Auth::logout();
                throw ValidationException::withMessages([
                    'role' => 'The specified role does not match the logged-in user.',
                ]);
            }
    
            // Clear the rate limiter after successful login
            RateLimiter::clear($this->throttleKey());
        } else {
            // If authentication fails, hit the rate-limiter to limit further attempts
            RateLimiter::hit($this->throttleKey());
    
            // Throw a validation exception for failed login
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}