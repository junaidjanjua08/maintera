@extends('admin.app')
@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Order Management</h2>
        <form class="d-flex gap-2" method="GET" action="{{ route('admin.orders.index') }}">
            <input type="text" name="search" class="form-control" placeholder="Search by ID, customer, technician, description..." value="{{ request('search') }}" style="width: 250px;">
            <select name="status" class="form-select">
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @if(request('status', 'all') == $status) selected @endif>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <select name="technician_id" class="form-select">
                <option value="">All Technicians</option>
                @foreach($technicians as $tech)
                    <option value="{{ $tech->id }}" @if(request('technician_id') == $tech->id) selected @endif>{{ $tech->name }}</option>
                @endforeach
            </select>
            <select name="customer_id" class="form-select">
                <option value="">All Customers</option>
                @foreach($customers as $cust)
                    <option value="{{ $cust->id }}" @if(request('customer_id') == $cust->id) selected @endif>{{ $cust->name }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Filter</button>
        </form>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Technician</th>
                            <th>Status</th>
                            <th>Fare</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>
                                <div class="fw-semibold">{{ $order->customer->name ?? '-' }}</div>
                                <div class="text-muted small">{{ $order->customer->email ?? '' }}</div>
                            </td>
                            <td>
                                @if($order->technician)
                                    <div class="fw-semibold">{{ $order->technician->name }}</div>
                                    <div class="text-muted small">{{ $order->technician->email }}</div>
                                @else
                                    <span class="badge bg-warning">Unassigned</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{
                                    $order->status === 'pending' ? 'warning' :
                                    ($order->status === 'accepted' ? 'info' :
                                    ($order->status === 'in_progress' ? 'primary' :
                                    ($order->status === 'completed' ? 'success' :
                                    ($order->status === 'cancelled' ? 'danger' : 'secondary'))))
                                }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $acceptedFare = $order->fareOffers->where('status', 'accepted')->first();
                                @endphp
                                @if($acceptedFare)
                                    <span class="fw-bold">PKR {{ number_format($acceptedFare->proposed_price) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="d-block">{{ $order->created_at->format('M d, Y') }}</span>
                                <span class="text-muted small">{{ $order->created_at->diffForHumans() }}</span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderDetailsModal{{ $order->id }}">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer py-3">
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
</div>

{{-- Render modals after the table --}}
@foreach($orders as $order)
<div class="modal fade" id="orderDetailsModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderDetailsModalLabel{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="orderDetailsModalLabel{{ $order->id }}">Order #{{ $order->id }}: Customer & Technician Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0 align-middle text-center" style="min-width: 400px;">
                        <thead class="table-light">
                            <tr>
                                <th>Customer</th>
                                <th>Technician</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="max-width: 200px; white-space: normal; word-break: break-word;">
                                    <div><strong>{{ $order->customer->name ?? '-' }}</strong></div>
                                    <div class="text-muted small">{{ $order->customer->email ?? '' }}</div>
                                </td>
                                <td style="max-width: 200px; white-space: normal; word-break: break-word;">
                                    @if($order->technician)
                                        <div><strong>{{ $order->technician->name }}</strong></div>
                                        <div class="text-muted small">{{ $order->technician->email }}</div>
                                    @else
                                        <span class="badge bg-warning">Unassigned</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection 