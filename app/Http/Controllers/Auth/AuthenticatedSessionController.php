<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request)
    {
        
        // Check if the user is already logged in
        if (Auth::check()) {
            // Redirect the authenticated user to their dashboard based on their role
            $user = Auth::user();
            
            if ($user->role === 'technician') {
                return redirect()->route('technician.dashboard');
            }
    
            return redirect()->route('dashboard');
        }
    
        // Get the role from the query string (if available) or session (if stored previously)
        $role = $request->query('role') ?? session('role');
        
        // Pass the role to the view
        return view('auth.login', compact('role'));
    }
    
    

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // dd($request);
        // Authenticate the user
        $request->authenticate();
    
        // Regenerate the session after successful login
        $request->session()->regenerate();
    
        // Redirect the user based on their role
        $user = Auth::user();
    
        if ($user->role === 'customer') {
            return redirect()->route('home');
        } elseif ($user->role === 'technician') {
            return redirect()->route('technician.dashboard');
        }
    
        // Fallback to the default home route
        return redirect()->intended(RouteServiceProvider::HOME);
    }
    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
