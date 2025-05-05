<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function dashboard(){
        $customers = User::where('role','customer')->count();
        $technicians = User::where('role','technician')->count();
        $tech_requests = User::where('role','technician')->where('status','inactive')->count();
        

        return view('admin.index',compact('customers','technicians','tech_requests'));
    }



    public function inactiveTechnicians()
{
    $technicians = User::where('role', 'technician')
                        ->where('status', 'inactive')
                        ->get();

    return view('admin.technician-requests', compact('technicians'));
}


public function index()
{
    $categories = ServiceCategory::all();
    $services = Service::with('category')->latest()->paginate(10); // paginate(10)
    return view('admin.manage-services', compact('categories', 'services'));
}


public function storeCategory(Request $request)
{
    $request->validate(['category_name' => 'required|string|max:255']);
    ServiceCategory::create(['name' => $request->category_name]);

    return back()->with('sweet_success', 'Category added successfully.');
}

public function storeService(Request $request)
{
    // dd($request);
    $request->validate([
        'category_id' => 'required|exists:service_categories,id',
        'service_name' => 'required|string|max:255',
        'service_description' => 'nullable|string',
    ]);

    Service::create([
        'category_id' => $request->category_id,
        'name' => $request->service_name,
        'description' => $request->service_description,
    ]);

    return back()->with('sweet_success', 'Service added successfully.');
}

public function destroyService(Service $service)
{
    $service->delete();
    return back()->with('sweet_success', 'Service deleted.');
}
}
