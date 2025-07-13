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

                        <!-- Order Details Modal -->
                        <div class="modal fade" id="orderDetailsModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderDetailsModalLabel{{ $order->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="orderDetailsModalLabel{{ $order->id }}">Order #{{ $order->id }} Details</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-light" style="border-radius: 1rem;">
                                        <!-- Order Status Timeline -->
                                        <div class="mb-4">
                                            <div class="d-flex justify-content-between align-items-center">
                                                @php
                                                    $statuses = ['pending', 'accepted', 'in_progress', 'completed', 'cancelled'];
                                                    $currentIndex = array_search($order->status, $statuses);
                                                @endphp
                                                @foreach($statuses as $i => $status)
                                                    <div class="text-center flex-fill">
                                                        <div class="rounded-circle mx-auto mb-1"
                                                             style="width:36px;height:36px;line-height:36px;
                                                                    background: {{ $i <= $currentIndex ? '#6366f1' : '#e5e7eb' }};
                                                                    color: white; font-weight: bold;">
                                                            <i class="fas fa-{{ 
                                                                $status === 'pending' ? 'hourglass-half' :
                                                                ($status === 'accepted' ? 'handshake' :
                                                                ($status === 'in_progress' ? 'spinner' :
                                                                ($status === 'completed' ? 'check-circle' : 'times-circle')))
                                                            }}"></i>
                                                        </div>
                                                        <small class="{{ $i <= $currentIndex ? 'text-primary' : 'text-muted' }}">
                                                            {{ ucwords(str_replace('_', ' ', $status)) }}
                                                        </small>
                                                    </div>
                                                    @if($i < count($statuses) - 1)
                                                        <div class="flex-fill" style="height:4px; background:{{ $i < $currentIndex ? '#6366f1' : '#e5e7eb' }};"></div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <!-- Customer & Technician Cards -->
                                        <div class="row mb-4">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <div class="card border-0 shadow animate__animated animate__fadeIn" style="background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%); border-left: 5px solid #6366f1;">
                                                    <div class="card-body d-flex align-items-center">
                                                        <div class="me-3">
                                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($order->customer->name ?? 'C') }}&background=6c63ff&color=fff&size=64" class="rounded-circle shadow" alt="Customer Avatar">
                                                        </div>
                                                        <div>
                                                            <h6 class="fw-bold mb-1 text-primary"><i class="fas fa-user me-1"></i> Customer</h6>
                                                            <div class="mb-1"><span class="fw-semibold">Name:</span> {{ $order->customer->name ?? '-' }}</div>
                                                            <div class="mb-1"><span class="fw-semibold">Email:</span> <span class="text-muted">{{ $order->customer->email ?? '-' }}</span></div>
                                                            <div class="mb-1"><span class="fw-semibold">Phone:</span> <span class="text-muted">{{ $order->customer->phone ?? '-' }}</span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card border-0 shadow animate__animated animate__fadeIn" style="background: linear-gradient(135deg, #f0abfc 0%, #fef9c3 100%); border-left: 5px solid #f59e42;">
                                                    <div class="card-body d-flex align-items-center">
                                                        <div class="me-3">
                                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($order->technician->name ?? 'T') }}&background=f59e42&color=fff&size=64" class="rounded-circle shadow" alt="Technician Avatar">
                                                        </div>
                                                        <div>
                                                            <h6 class="fw-bold mb-1 text-warning"><i class="fas fa-tools me-1"></i> Technician</h6>
                                                            <div class="mb-1"><span class="fw-semibold">Name:</span> {{ $order->technician->name ?? '-' }}</div>
                                                            <div class="mb-1"><span class="fw-semibold">Email:</span> <span class="text-muted">{{ $order->technician->email ?? '-' }}</span></div>
                                                            <div class="mb-1"><span class="fw-semibold">Phone:</span> <span class="text-muted">{{ $order->technician->phone ?? '-' }}</span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Address & Description -->
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <div class="card mb-0 border-0 shadow-sm" style="border-left: 5px solid #6366f1;">
                                                    <div class="card-body">
                                                        <h6 class="fw-bold mb-2 text-primary"><i class="fas fa-map-marker-alt me-1"></i> Address</h6>
                                                        <span class="text-muted">{{ $order->street_address }}, {{ $order->area }}, {{ $order->city }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card mb-0 border-0 shadow-sm" style="border-left: 5px solid #a21caf;">
                                                    <div class="card-body">
                                                        <h6 class="fw-bold mb-2 text-purple"><i class="fas fa-align-left me-1"></i> Description</h6>
                                                        <div class="border rounded p-3 bg-white shadow-sm">{{ $order->description }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Status & Created -->
                                        <div class="mb-3 d-flex align-items-center gap-3">
                                            <span class="fw-semibold">Status:</span>
                                            <span class="badge rounded-pill px-4 py-2 fs-6 bg-{{ 
                                                $order->status === 'pending' ? 'warning' :
                                                ($order->status === 'accepted' ? 'info' :
                                                ($order->status === 'in_progress' ? 'primary' :
                                                ($order->status === 'completed' ? 'success' :
                                                ($order->status === 'cancelled' ? 'danger' : 'secondary'))))
                                            }}">
                                                <i class="fas fa-{{ 
                                                    $order->status === 'pending' ? 'hourglass-half' :
                                                    ($order->status === 'accepted' ? 'handshake' :
                                                    ($order->status === 'in_progress' ? 'spinner' :
                                                    ($order->status === 'completed' ? 'check-circle' :
                                                    ($order->status === 'cancelled' ? 'times-circle' : 'question-circle'))))
                                                }} me-1"></i>
                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                            <span class="fw-semibold ms-auto">Created:</span>
                                            <span class="text-muted small">{{ $order->created_at->format('M d, Y h:i A') }} ({{ $order->created_at->diffForHumans() }})</span>
                                        </div>
                                        <!-- Fare Offers as Cards -->
                                        <div class="mb-3">
                                            <span class="fw-semibold">Fare Offers:</span>
                                            @if($order->fareOffers->count())
                                                <div class="row g-3 mt-2">
                                                    @foreach($order->fareOffers as $fare)
                                                    <div class="col-md-6">
                                                        <div class="card shadow position-relative border-0 animate__animated animate__fadeIn" style="overflow:visible; border-left: 5px solid #6366f1;">
                                                            @if($fare->status === 'accepted')
                                                                <span class="position-absolute top-0 end-0 badge bg-success" style="transform: translateY(-50%);">Accepted</span>
                                                            @elseif($fare->status === 'rejected')
                                                                <span class="position-absolute top-0 end-0 badge bg-danger" style="transform: translateY(-50%);">Rejected</span>
                                                            @endif
                                                            <div class="card-body d-flex align-items-center">
                                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($fare->technician->name ?? 'T') }}&background=6366f1&color=fff&size=40" class="rounded-circle me-3" style="width:40px;height:40px;" alt="Avatar">
                                                                <div>
                                                                    <div class="fw-bold text-primary">PKR {{ number_format($fare->proposed_price) }}</div>
                                                                    <div class="text-muted small">{{ $fare->technician->name ?? 'Technician' }}</div>
                                                                    @if($fare->note)
                                                                        <div class="text-muted fst-italic small mt-1">{{ $fare->note }}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted">No fare offers yet.</span>
                                            @endif
                                        </div>
                                        <!-- Review Section with Star Rating -->
                                        @if($order->review)
                                        <div class="card border-0 shadow mb-3 animate__animated animate__fadeIn" style="background: linear-gradient(90deg, #f0abfc 0%, #a7f3d0 100%); border-left: 5px solid #22c55e;">
                                            <div class="card-body">
                                                <div class="mb-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star{{ $i <= $order->review->rating ? ' text-warning' : ' text-secondary' }}"></i>
                                                    @endfor
                                                    <span class="fw-bold ms-2">{{ $order->review->rating }}/5</span>
                                                </div>
                                                <div class="fst-italic">"{{ $order->review->review }}"</div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
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
@endsection 