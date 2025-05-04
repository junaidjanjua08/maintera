<?php

namespace App\Http\Controllers;

use App\Models\FareOffer;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   


    public function order_requests()
    {
        $requested_orders = Order::where('status', 'pending')->get();
        return view('technician.pages.order-requests', compact('requested_orders'));
    }

    public function pending_orders()
    {
        
        $technicianId = auth()->id(); // or Auth::user()->id

        $pending_orders = FareOffer::with('order')
        ->where('technician_id', $technicianId)
        ->where('status', 'accepted')
        ->whereHas('order', function ($query) {
            $query->where('status', 'pending');
        })
        ->get();


        return view('technician.pages.pending-orders', compact('pending_orders'));
    }

    public function completed_orders()
    {
        $technicianId = auth()->id(); // or Auth::user()->id
        $completed_orders = FareOffer::with('order')
            ->where('technician_id', $technicianId)
            ->where('status', 'accepted')
            ->whereHas('order', function ($query) {
                $query->whereIn('status',  'completed');
            })
            ->get();



        return view('technician.pages.completed-orders', compact('completed_orders'));
    }


    public function view_order(Request $request)
    {
        $subcategory_name = $request->subcategory_name;
        $description = $request->description;
        $area = $request->area;
        $order_id = $request->order_id;
        $city = $request->city;
        $customer_name = $request->customer_name;
        $email = $request->email;
        $phone = $request->phone;
        $address = $request->address;
        $status = $request->status;
        $route = $request->route;

        $statuses = Order::distinct('status')->pluck('status');
       
        
    
        return view('technician.pages.orderview', compact(
            'subcategory_name',
            'description',
            'area',
            'city',
            'customer_name',
            'email',
            'phone',
            'address',
            'status',
            'order_id',
            'route',
            'statuses'
        ));
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
        'status' => 'accepted',
    ]);

    return redirect()->route('technician.orders.requests')->with('sweet_success', 'Fare offer submitted successfully!');
}
    

public function updateStatus(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'status' => 'required|in:pending,offer_received,accepted,in_progress,completed,cancelled',
    ]);

    $order = Order::findOrFail($request->order_id);
    $order->status = $request->status;
    $order->save();

    return response()->json(['message' => 'Status updated successfully']);
}

}