<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Order;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function services()
    {
        // Fetch all services
        $services = Service::with('category')->get();

        return view('services.index', compact('services'));
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
            $request->validate([
                'date' => 'required|date',
                'time' => 'required',
                'payment_method' => 'required|in:credit_card,cash',
                'description' => 'nullable|string',
            ]);
        
            // Combine date and time into a single timestamp
            $scheduledAt = \Carbon\Carbon::parse($request->date . ' ' . $request->time);
            $order = new Order();
            $order->user_id = Auth::id(); // Authenticated customer
            $order->category_id = $request->category_id; // should be passed or inferred
            $order->subcategory_id = $request->subcategory_id; // should be passed
            // $order->service_id = $request->service_id; // from route or form
            $order->street_address = $request->street_adress;
            $order->city = $request->city;
            $order->area = $request->area;
            $order->sub_area = $request->sub_area;
            $order->latitude = $request->lat_route;
            $order->longitude = $request->lng_route;
            $order->description = $request->description;
            $order->scheduled_at = $scheduledAt;
            $order->payment_mode = $request->payment_method;
            $order->status = 'pending'; // initial state
            $order->save();
        
            return redirect()->back()->with('sweet_success', 'Booking submitted successfully! Our technicians will respond soon.');
        }
    


}
