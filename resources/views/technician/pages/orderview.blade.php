@extends('technician.index')

@section('content')
<style>
    body {
        background: #f9f9f9;
        font-family: 'Roboto', sans-serif;
        color: #333;
    }

    .order-details {
        background: #fff;
        padding: 3rem;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        margin-top: 2rem;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 1.25rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 0.5rem;
    }

    .info-group {
        margin-bottom: 2rem;
    }

    .info-label {
        font-size: 1rem;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .info-value {
        font-size: 1.125rem;
        font-weight: 500;
        color: #333;
        background: #f8f9fa;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        border: 1px solid #ddd;
        transition: all 0.3s ease-in-out;
    }

    .info-value:hover {
        background: #e9ecef;
        border-color: #b5b5b5;
    }

    .back-btn {
        display: inline-block;
        font-size: 0.95rem;
        padding: 12px 24px;
        border-radius: 18px;
        border: none;
        background: #007bff;
        color: white;
        font-weight: 600;
        transition: background 0.3s ease;
        text-decoration: none;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
    }

    .back-btn:hover {
        background: #0056b3;
    }

    hr {
        border-top: 1px solid #e0e0e0;
        margin: 2rem 0;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
    }

    .col-md-6 {
        width: 50%;
        padding-right: 15px;
        padding-left: 15px;
    }

    .col-md-4 {
        width: 33.33%;
        padding-right: 15px;
        padding-left: 15px;
    }

    .col-md-12 {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
    }

    .order-card {
        background: #ffffff;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .order-card:hover {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .order-card-header {
        font-size: 1.25rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .order-card-body {
        display: flex;
        flex-wrap: wrap;
    }

    .order-card-body > div {
        width: 50%;
        padding-right: 1rem;
        padding-left: 1rem;
        margin-bottom: 1rem;
    }

    .order-card-body > div .info-label {
        font-size: 1rem;
        font-weight: 600;
        color: #6b7280;
    }

    .order-card-body > div .info-value {
        font-size: 1.125rem;
        font-weight: 500;
        color: #333;
        padding: 0.75rem;
        border-radius: 8px;
        background: #f8f9fa;
    }

    @media (max-width: 768px) {
        .col-md-6, .col-md-4, .col-md-12 {
            width: 100%;
            margin-bottom: 1rem;
        }

        .back-btn {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="container">
    <a href="{{ $route }}" class="back-btn">← Back to Orders</a>

    <div class="order-details">
        <div class="section-title">📝 Order Details</div>

<div class="order-card">
    <div class="order-card-header">Order # {{ $order_id }}</div>
    <div class="order-card-body">
        <div>
            <div class="info-label">Service</div>
            <div class="info-value">{{ $subcategory_name ?? 'N/A' }}</div>
        </div>

        <div>
            <div class="info-label">Order Status</div>
            <div class="info-value">
                <form id="statusUpdateForm">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order_id }}">
        
                    <select name="status" id="statusSelect" class="form-select form-select-sm w-auto d-inline-block">
                        @foreach(['pending', 'offer_received', 'accepted', 'in_progress', 'completed', 'cancelled'] as $option)
                            <option value="{{ $option }}" {{ $status === $option ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $option)) }}
                            </option>
                        @endforeach
                    </select>
        
                    <span id="statusUpdateMsg" class="text-success ms-2" style="display: none;">✔ Updated</span>
                </form>
            </div>
        </div>
        
        <div>
            <div class="info-label">Description</div>
            <div class="info-value">{{ $description ?? 'No description provided' }}</div>
        </div>
    </div>
</div>

        <hr>

        <div class="section-title">📍 Location Information</div>

        <div class="order-card">
            <div class="order-card-header">Location Info</div>
            <div class="order-card-body">
                <div>
                    <div class="info-label">City</div>
                    <div class="info-value">{{ $city ?? 'N/A' }}</div>
                </div>
                <div>
                    <div class="info-label">Area</div>
                    <div class="info-value">{{ $area ?? 'N/A' }}</div>
                </div>
                <div>
                    <div class="info-label">Full Address</div>
                    <div class="info-value">{{ $address ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <hr> 

        <div class="section-title">👤 Customer Information</div>

        <div class="order-card">
            <div class="order-card-header">Customer Info</div>
            <div class="order-card-body">
                <div>
                    <div class="info-label">Full Name</div>
                    <div class="info-value">{{ $customer_name ?? 'N/A' }}</div>
                </div>
                <div>
                    <div class="info-label">Phone Number</div>
                    <div class="info-value">{{ $phone ?? 'N/A' }}</div>
                </div>
                <div>
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $email ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Offer Fare Button -->
        <div style="margin-top: 1.5rem;">
            <button class="back-btn" style="background-color: #28a745;" data-bs-toggle="modal" data-bs-target="#offerFareModal">
                💰 Offer Fare
            </button>
        </div>
    </div>
</div>

<!-- Offer Fare Modal -->
<div class="modal fade" id="offerFareModal" tabindex="-1" aria-labelledby="offerFareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <form action="{{ route('technician.fare.offer') }}" method="POST" class="w-100">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order_id }}">
        <input type="hidden" name="technician_id" value="{{ auth()->id() }}">
  
        <div class="modal-content shadow-lg border-0 rounded-4">
          <div class="modal-header border-0 bg-success text-white rounded-top-4 px-4 py-3">
            <h5 class="modal-title fw-semibold" id="offerFareModalLabel">💼 Offer a Fare</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
  
          <div class="modal-body p-4">
            <div class="mb-4">
              <label for="proposed_price" class="form-label fw-medium">💰 Proposed Price (PKR)</label>
              <input type="number" name="proposed_price" id="proposed_price" class="form-control form-control-lg shadow-sm" required min="0" step="0.01" placeholder="Enter your price offer">
            </div>
  
            <div class="mb-3">
              <label for="note" class="form-label fw-medium">📝 Optional Note</label>
              <textarea name="note" id="note" rows="4" class="form-control shadow-sm" placeholder="Write a short message to the customer..."></textarea>
            </div>
          </div>
  
          <div class="modal-footer border-0 px-4 pb-4">
            <button type="submit" class="btn btn-success btn-lg px-4">📤 Send Offer</button>
            <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-bs-dismiss="modal">❌ Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  


@endsection

<script>
    $(document).ready(function () {
        $('#statusSelect').on('change', function () {
            console.log('execute');
            let formData = $('#statusUpdateForm').serialize();
    
            $.ajax({
                url: "{{ route('technician.orders.updateStatus') }}",
                method: 'POST',
                data: formData,
                success: function (response) {
                    $('#statusUpdateMsg').fadeIn().delay(1500).fadeOut();
                },
                error: function () {
                    alert('Failed to update status.');
                }
            });
        });
    });
    </script>
