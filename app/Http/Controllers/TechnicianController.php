<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TechnicianController extends Controller
{
    public function index()
    {
        // Get the count of each type of order
        $orderRequests = Order::where('status', 'request')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        // Return the dashboard view with the order counts
        return view('technician.pages.dashboard', compact('orderRequests', 'pendingOrders', 'completedOrders'));
    }
    public function settings()
    {
        return view('technician.pages.settings');
    }




    public function updateEmail(Request $request)
{
    // dd($request);
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|unique:users,email,' . Auth::id(),
    ]);

    if ($validator->fails()) {
        return redirect()->route('technician.settings')
            ->withErrors($validator)
            ->withInput();
    }

    // Update the user's email address
    $user = Auth::user();
    // dd($user);
    $user->email = $request->email;
    $user->save();

    return redirect()->route('technician.settings')->with('sweet_success', 'Email updated successfully!');
}


public function updatePassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'currentPassword' => 'required',
        'newpassword' => 'required|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect()->route('technician.settings')
            ->withErrors($validator)
            ->withInput();
    }

    $user = Auth::user();

    if (!Hash::check($request->currentPassword, $user->password)) {
        return redirect()->route('technician.settings')
            ->withErrors(['currentPassword' => 'Current password is incorrect.'])
            ->withInput();
    }

    $user->password = Hash::make($request->newpassword); // updated to match form name
    $user->save();

    return redirect()->route('technician.settings')->with('sweet_success', 'Password updated successfully!');
}

public function deleteAccount(Request $request)
{
    // Confirm that the user is logged in
    $user = Auth::user();
    
    // Delete the user's account and all related data
    // For example, this can include deleting their posts, comments, etc.
    // You may want to add soft delete for safety if needed.
    
    // Deleting user account from the database
    $user->delete();
    
    // Logout the user after deletion
    Auth::logout();

    // Redirect to the home page with a success message
    return redirect('/')->with('sweet_success', 'Your account has been deleted successfully.');
}
}
