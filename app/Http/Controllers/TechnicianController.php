<?php

namespace App\Http\Controllers;

use App\Models\FareOffer;
use App\Models\Order;
use App\Models\OrderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\TechnicianProfile;

class TechnicianController extends Controller
{
    public function index()
    {
        // Clear the order view source session when navigating to dashboard
        session()->forget('order_view_source');
        
        // Get the count of each type of order
        $orderRequests = OrderRequest::whereHas('order', function ($query) {
            $query->where('status', 'pending');
        })->where('technician_id', auth()->id())->count();

        $pendingOrders = FareOffer::with('order')
            ->where('technician_id', auth()->id())
            ->where('status', 'accepted')
            ->whereHas('order', function ($query) {
                $query->where('status', 'pending');
            })
            ->count();

        // Only completed orders for the authenticated technician
        $completedOrders = Order::where('status', 'completed')
            ->where('technician_id', auth()->id())
            ->count();

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

        // Set user status to inactive
        $user->status = 'inactive';
        $user->save();

        // Also update technician profile availability if exists
        if ($user->technicianProfile) {
            $user->technicianProfile->update([
                'is_available' => false
            ]);
        }

        Auth::logout();

        return redirect('/')->with('sweet_success', 'Your account has been deactivated successfully. You can contact support to reactivate your account if needed.');
    }

    /**
     * Show the form for editing the technician's profile.
     */
    public function editProfile()
    {
        $user = auth()->user();
        
        // Try to get the profile directly from the database
        $profile = \App\Models\TechnicianProfile::where('user_id', $user->id)->first();
        
        // If no profile exists, create an empty one for the form
        if (!$profile) {
            $profile = new \App\Models\TechnicianProfile();
        }

        return view('technician.pages.edit_profile', compact('user', 'profile'));
    }

    /**
     * Update the technician's profile.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'occupation' => 'required|array',
            'occupation.*' => 'string|max:255',
            'experience' => 'required|string|max:50',
            'qualification' => 'required|string|max:255',
            'address' => 'required|string',
            'street_number' => 'nullable|string|max:50',
            'route' => 'nullable|string|max:255',
            'locality' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:255',
        ]);

        // Update user information
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old profile image if exists
            if ($user->technicianProfile && $user->technicianProfile->profile_image) {
                $oldImagePath = public_path($user->technicianProfile->profile_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/technician-profiles'), $imageName);
            $validated['profile_image'] = 'uploads/technician-profiles/' . $imageName;
        }

        // Remove user fields from profile data
        unset($validated['name'], $validated['email']);

        // Store occupation as array (JSON)
        $validated['occupation'] = array_values($validated['occupation']);

        // Update or create profile
        if ($user->technicianProfile) {
            $user->technicianProfile->update($validated);
        } else {
            $validated['user_id'] = $user->id;
            TechnicianProfile::create($validated);
        }

        return redirect()->route('technician.editprofile')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update technician availability status.
     */
    public function updateAvailability(Request $request)
    {
        $validated = $request->validate([
            'is_available' => 'required|boolean'
        ]);

        $user = auth()->user();
        if ($user->technicianProfile) {
            $user->technicianProfile->update($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Availability updated successfully'
        ]);
    }

    /**
     * Create a new technician profile record.
     */
    public function createProfile(Request $request)
    {
        
        $user = auth()->user();

        // Check if profile already exists
        if ($user->technicianProfile) {
            return redirect()->route('technician.editprofile')
                ->with('error', 'Profile already exists. Please use the update form.');
        }

        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'occupation' => 'required|array',
            'occupation.*' => 'string|max:255',
            'experience' => 'required|string|max:50',
            'qualification' => 'required|string|max:255',
            'address' => 'required|string',
            'street_number' => 'nullable|string|max:50',
            'route' => 'nullable|string|max:255',
            'locality' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:255',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/technician-profiles'), $imageName);
            $validated['profile_image'] = 'uploads/technician-profiles/' . $imageName;
        }

        // Create new profile
        $validated['user_id'] = $user->id;
        // Store occupation as array (JSON)
        $validated['occupation'] = array_values($validated['occupation']);
        TechnicianProfile::create($validated);

        return redirect()->route('technician.editprofile')
            ->with('success', 'Profile created successfully.');
    }



    public function Offer_Fair(Request $request)
    {
        // dd($request);
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'technician_id' => 'required|exists:users,id',
            'proposed_price' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ]);
    
        FareOffer::create([
            'order_id' => $request->order_id,
            'technician_id' => $request->technician_id,
            'proposed_price' => $request->proposed_price,
            'note' => $request->note,
            'status' => 'Pending',
        ]);
    
        $order_req = OrderRequest::where('technician_id', Auth()->id())
            ->where('order_id', $request->order_id)
            ->first();

        if ($order_req) {
            $order_req->fare_offer = 1.0;
            $order_req->save();
        }
      
        
        // Notify the customer about the new fare offer
        $order = \App\Models\Order::find($request->order_id);
        $customer = $order ? $order->user : null;
        if ($customer) {
            $fareOffer = \App\Models\FareOffer::where('order_id', $order->id)
                ->where('technician_id', $request->technician_id)
                ->latest()->first();
            if ($fareOffer) {
                $customer->notify(new \App\Notifications\TechnicianFareOffer($fareOffer));
            }
        }
    
        return redirect()->route('technician.orders.requests')->with('sweet_success', 'Fare offer submitted successfully!');
    }


}
