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
}
