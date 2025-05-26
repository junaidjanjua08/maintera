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
  
       
        
        public function OrderBooking(Request $request)
        {
            // dd($request);
            try {
                $request->validate([
                    'date' => 'required|date',
                    'time' => 'required',
                    'payment_method' => 'required|in:credit_card,cash',
                    'description' => 'nullable|string',
                    'lat_route' => 'required',
                    'lng_route' => 'required',
                    'address' => 'required|string',
                    'locality' => 'required|string',
                    'area' => 'nullable|string',
                    'sub_area' => 'nullable|string',
                    'category_id' => 'required',
                    'subcategory_id' => 'required'
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                dd('Validation Errors:', $e->errors());
            }
            
            // dd('Debug Point 2: After validation');
        
            // Combine date and time into a single timestamp
            $scheduledAt = \Carbon\Carbon::parse($request->date . ' ' . $request->time);
            $order = new Order();
            $order->user_id = Auth::id(); // Authenticated customer
            $order->category_id = $request->category_id;
            $order->subcategory_id = $request->subcategory_id;
            $order->street_address = $request->address;
            $order->city = $request->locality;
            $order->area = $request->area;
            $order->sub_area = $request->sub_area;
            $order->latitude = $request->lat_route;
            $order->longitude = $request->lng_route;
            $order->description = $request->description;
            $order->scheduled_at = $scheduledAt;
            $order->payment_mode = $request->payment_method;
            $order->status = 'pending'; // Changed to 'request' to indicate it's waiting for technician offers
            $order->save();

            // dd('Debug Point 4: After saving order');

            // Find nearby technicians (within 10km radius)
            $nearbyTechnicians = \App\Models\User::whereHas('technicianProfile', function($query) {
                $query->where('is_available', true)
                      ->where('is_verified', true);
            })
            ->where('role', 'technician')
            ->with('technicianProfile')  // Eager load the relationship
            ->get();
        

            if ($nearbyTechnicians->isEmpty()) {
                \Log::warning('No nearby technicians found');
                return redirect()->back()->with('error', 'No technicians available in your area at the moment.');
            }

            $nearbyTechnicians = $nearbyTechnicians->filter(function($technician) use ($request) {
                // Calculate distance using Haversine formula
                $distance = $this->calculateDistance(
                    $request->lat_route,
                    $request->lng_route,
                    $technician->technicianProfile->latitude,
                    $technician->technicianProfile->longitude
                );
                return $distance <= 10; // 10km radius
            });

           

            // Create order request for each nearby technician
            foreach ($nearbyTechnicians as $technician) {
                \App\Models\OrderRequest::create([
                    'order_id' => $order->id,
                    'technician_id' => $technician->id,
                    'status' => 'pending',
                    'distance' => $this->calculateDistance(
                        $request->lat_route,
                        $request->lng_route,
                        $technician->technicianProfile->latitude,
                        $technician->technicianProfile->longitude
                    )
                ]);

                // Send notification to technician
                $technician->notify(new \App\Notifications\NewOrderRequest($order));
            }
        
            return redirect()->back()->with('sweet_success', 'Booking submitted successfully! Nearby technicians will be notified.');
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
}
