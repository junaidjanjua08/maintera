<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

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
        return view('welcome', compact('serviceCategories'));
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


}
