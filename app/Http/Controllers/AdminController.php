<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\TechnicianProfile;
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
        $technicians = TechnicianProfile::with('user')
            ->whereHas('user', function($query) {
                $query->where('role', 'technician')
                      ->where('status', 'inactive');
            })
            ->get();

        return view('admin.technician-requests', compact('technicians'));
    }

    public function toggleTechnicianStatus(User $technician)
    {
        // Toggle the status between active and inactive
        $technician->status = $technician->status === 'active' ? 'inactive' : 'active';
        $technician->save();

        $status = $technician->status === 'active' ? 'activated' : 'deactivated';
        return back()->with('success', "Technician account has been {$status} successfully.");
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

    public function destroyCategory(ServiceCategory $category)
    {
        // Delete all services associated with this category
        $category->services()->delete();
        // Delete the category
        $category->delete();
        return back()->with('sweet_success', 'Category and its services deleted successfully.');
    }

    public function viewTechnicianProfile(User $technician)
    {
        $technicianProfile = $technician->technicianProfile;
        return view('admin.technician-profile', compact('technicianProfile'));
    }

    public function acceptedTechnicians()
    {
        $technicians = User::where('role', 'technician')
            ->whereHas('technicianProfile', function ($query) {
                $query->where('status', 'active');
            })
            ->with(['technicianProfile'])
            ->get()
            ->map(function ($technician) {
                return [
                    'id' => $technician->id,
                    'name' => $technician->name,
                    'email' => $technician->email,
                    'phone' => $technician->technicianProfile->phone,
                    'occupation' => $technician->technicianProfile->occupation,
                    'experience' => $technician->technicianProfile->experience,
                    'services' => $technician->technicianProfile->services ?? [],
                    'fields_of_work' => $technician->technicianProfile->fields_of_work ?? [],
                    'skills' => $technician->technicianProfile->skills ?? [],
                    'bio' => $technician->technicianProfile->bio,
                    'status' => $technician->technicianProfile->status,
                    'profile_image' => $technician->technicianProfile->profile_image
                ];
            });

        return view('admin.accepted-requests', compact('technicians'));
    }

    public function rejectedTechnicians()
    {
        $technicians = User::where('role', 'technician')
            ->whereHas('technicianProfile', function ($query) {
                $query->where('status', 'rejected');
            })
            ->with(['technicianProfile'])
            ->get()
            ->map(function ($technician) {
                return [
                    'id' => $technician->id,
                    'name' => $technician->name,
                    'email' => $technician->email,
                    'phone' => $technician->technicianProfile->phone,
                    'occupation' => $technician->technicianProfile->occupation,
                    'experience' => $technician->technicianProfile->experience,
                    'services' => $technician->technicianProfile->services ?? [],
                    'fields_of_work' => $technician->technicianProfile->fields_of_work ?? [],
                    'skills' => $technician->technicianProfile->skills ?? [],
                    'bio' => $technician->technicianProfile->bio,
                    'status' => $technician->technicianProfile->status,
                    'profile_image' => $technician->technicianProfile->profile_image
                ];
            });

        return view('admin.rejected-requests', compact('technicians'));
    }

    public function manageTechnicians(Request $request)
    {
        $query = User::where('role', 'technician')
            ->with('technicianProfile');

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        $technicians = $query->get()
            ->map(function ($technician) {
                return [
                    'id' => $technician->id,
                    'name' => $technician->name,
                    'email' => $technician->email,
                    'services' => $technician->technicianProfile->services ?? [],
                    'status' => $technician->status === 'active',
                ];
            });

        return view('admin.manage-technician', compact('technicians'));
    }
}
