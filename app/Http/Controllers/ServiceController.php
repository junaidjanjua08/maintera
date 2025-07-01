<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Order;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\OrderRequest;
use App\Notifications\NewOrderRequest;

class ServiceController extends Controller
{
    public function services()
    {
        
        // Fetch all services
        $serviceCategories = ServiceCategory::all();

        return view('services', compact('serviceCategories'));
    }
    public function home()
    {
        // Fetch all services
        $serviceCategories = ServiceCategory::all();
        // dd($serviceCategories);
        return view('welcome', compact('serviceCategories'));
    }
   // ServiceController.php

public function ServiceBooking($id)
{
    // Fetch the service details based on the ID
    $service = Service::findOrFail($id);
    // Return the view and pass the service data
    return view('booking', compact('service'));
}


    public function showServices($categoryId)
    {
        // Find the category by its ID
        $category = ServiceCategory::findOrFail($categoryId);
        // dd($category);
        // Fetch services associated with this category
        $services = $category->services; // Assuming you've set up the relationship in the model
// dd($services);
        // Pass the category and services data to the view
        return view('sub-services', compact('category', 'services'));
    }
  
       
        
 

/**
 * Helper method to determine file type based on MIME type.
 */
private function getFileType(string $mime)
{
    if (str_starts_with($mime, 'image/')) {
        return 'image';
    } elseif (str_starts_with($mime, 'video/')) {
        return 'video';
    }
    return 'file';
}

    
    /**
     * Calculate distance between two points using Haversine formula
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Radius of the earth in km

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta/2) * sin($latDelta/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta/2) * sin($lonDelta/2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c;

        return $distance; // Distance in km
    }

    /**
     * Handle booking form submission, validate, upload media, and save order.
     */
    public function OrderBooking(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:service_categories,id',
            'subcategory_id' => 'required|integer|exists:services,id',
            'date' => 'required|date',
            'time' => 'required',
            'payment_method' => 'required|in:online,cash',
            'description' => 'nullable|string',
            'media_files.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480', // 20MB max per file
            'lat_route' => 'nullable|numeric',
            'lng_route' => 'nullable|numeric',
            'area' => 'nullable|string|max:255',
        ]);

        $mediaPaths = [];
        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                $path = $file->store('uploads/order-media', 'public');
                $mediaPaths[] = $path;
            }
        }

        $scheduledAt = $request->input('date') . ' ' . $request->input('time');

        $order = Order::create([
            'user_id' => auth()->id(),
            'category_id' => $request->input('category_id'),
            'subcategory_id' => $request->input('subcategory_id'),
            'description' => $request->input('description'),
            'street_address' => $request->input('address'),
            'city' => $request->input('locality') ?? '',
            'area' => $request->input('area') ?? '',
            'sub_area' => $request->input('sub_area') ?? '',
            'latitude' => $request->input('lat_route'),
            'longitude' => $request->input('lng_route'),
            'payment_mode' => $request->input('payment_method'),
            'scheduled_at' => $scheduledAt,
            'media' => $mediaPaths,
            'status' => 'pending',
        ]);

        // Notify nearby technicians within 30km
        $orderLat = $order->latitude;
        $orderLng = $order->longitude;

        // dd($orderLat);
        if ($orderLat && $orderLng) {
            $technicians = \App\Models\User::technicians()
                ->whereHas('technicianProfile', function ($q) {
                    $q->where('is_available', true)
                      ->whereNotNull('latitude')
                      ->whereNotNull('longitude');
                })
                ->with('technicianProfile')
                ->get();
// dd($technicians);
            foreach ($technicians as $technician) {
                $profile = $technician->technicianProfile;
                if ($profile && $profile->latitude && $profile->longitude) {
                    $distance = $this->calculateDistance($orderLat, $orderLng, $profile->latitude, $profile->longitude);
                    if ($distance <= 30) {
                        $technician->notify(new \App\Notifications\NewOrderRequest($order));
                    }
                }
            }
        }

        return redirect()->back()->with('sweet_success', 'Your booking has been submitted successfully!');
    }
}
