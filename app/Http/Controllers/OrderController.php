<?php

namespace App\Http\Controllers;

use App\Models\FareOffer;
use App\Models\Order;
use App\Models\OrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   


    public function order_requests()
    {
       $requested_orders = OrderRequest::with(['order','order.subcategory'])->whereHas('order', function ($query) {
    $query->where('status', 'pending');
})->where('technician_id', auth()->id())
->where('fare_offer',null)
    ->orderBy('created_at', 'desc')
    ->get();
    // dd($requested_orders);
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
        'status' => 'Pending',
    ]);

    $order_req = OrderRequest::where('order_id',$request->order_id)->get();
    $order_req->fare_offer = 1;
  
    
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

    // Customer: View all fare offers for an order
    public function viewOrderFares($orderId)
    {
        // dd($orderId);
        $order = \App\Models\Order::with('user')->findOrFail($orderId);
        $fareOffers = \App\Models\FareOffer::with('technician.technicianProfile')->where('order_id', $orderId)->get();
        return view('customer.order-fares', compact('order', 'fareOffers'));
    }

    // Customer: View technician profile
    public function viewTechnicianProfile($technicianId)
    {
        $technician = \App\Models\User::with('technicianProfile')->findOrFail($technicianId);
        return view('customer.technician-profile', compact('technician'));
    }

    // Customer: Accept a fare offer (assign order to technician)
    public function acceptFareOffer($orderId, $fareOfferId)
    {
        $order = \App\Models\Order::findOrFail($orderId);
        $fareOffer = \App\Models\FareOffer::findOrFail($fareOfferId);
        // Assign order to technician and update status
        $order->technician_id = $fareOffer->technician_id;
        $order->status = 'accepted';
        $order->save();
        // Delete all other fare offers for this order except the accepted one
        $deleted = \App\Models\FareOffer::where('order_id', $orderId)
            ->where('id', '!=', $fareOfferId)
            ->delete();
        dd($deleted); // This should show the number of deleted rows
        // Optionally notify the technician
        $technician = $fareOffer->technician;
        // $technician->notify(new \App\Notifications\OrderAccepted($order));
        return redirect()->route('customer.order.fares', $orderId)->with('sweet_success', 'You have accepted the fare offer. The order is now assigned to the technician.');
    }

}