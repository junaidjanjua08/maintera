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

                <!-- Action Buttons -->
        <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            @if($status !== 'completed' && $status !== 'cancelled')
                @if(!$isAssignedToTechnician)
                    <button class="back-btn" style="background-color: #28a745;" data-bs-toggle="modal" data-bs-target="#offerFareModal">
                        💰 Offer Fare
                    </button>
                @else
                    <button class="back-btn" style="background-color: #007bff;" onclick="markAsCompleted()">
                        ✅ Mark as Completed
                    </button>
                    
                    @if($status === 'pending')
                        <button class="back-btn" style="background-color: #dc3545;" onclick="cancelOrder()">
                            ❌ Cancel Order
                        </button>
                    @endif
                @endif
            @elseif($status === 'completed')
                <div class="alert alert-success" style="width: 100%;">
                    <i class="fas fa-check-circle"></i> This order has been marked as completed.
                </div>
            @elseif($status === 'cancelled')
                <div class="alert alert-danger" style="width: 100%;">
                    <i class="fas fa-times-circle"></i> This order has been cancelled.
                    @if(isset($order) && $order->cancellation_reason)
                        <hr>
                        <strong>Cancellation Reason:</strong><br>
                        {{ $order->cancellation_reason }}
                    @endif
                </div>
            @endif
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
  
  <!-- Cancel Order Modal -->
  <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header bg-danger text-white">
                  <h5 class="modal-title" id="cancelOrderModalLabel">
                      <i class="fas fa-exclamation-triangle"></i> Cancel Order
                  </h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="alert alert-warning">
                      <i class="fas fa-info-circle"></i>
                      <strong>Important:</strong> Please provide a clear reason for cancelling this order. This information will be shared with the customer.
                  </div>
                  <form id="cancelOrderForm">
                      <input type="hidden" id="cancelOrderId" name="order_id" value="{{ $order_id }}">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      
                      <div class="mb-3">
                          <label for="cancellation_reason" class="form-label fw-semibold">
                              <i class="fas fa-comment"></i> Cancellation Reason *
                          </label>
                          <textarea 
                              class="form-control" 
                              id="cancellation_reason" 
                              name="cancellation_reason" 
                              rows="4" 
                              required 
                              minlength="10" 
                              maxlength="500"
                              placeholder="Please provide a detailed reason for cancelling this order (minimum 10 characters)..."></textarea>
                          <div class="form-text">
                              <small class="text-muted">
                                  <span id="charCount">0</span>/500 characters
                              </small>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                      <i class="fas fa-times"></i> Close
                  </button>
                  <button type="button" class="btn btn-danger" onclick="submitCancellation()">
                      <i class="fas fa-check"></i> Confirm Cancellation
                  </button>
              </div>
          </div>
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
                error: function (xhr) {
                    if (xhr.status === 403) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Unauthorized',
                            text: 'You are not authorized to update this order status. This order is not assigned to you.'
                        });
                        // Reset the select to the original value
                        $(this).val('{{ $status }}');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update status.'
                        });
                        // Reset the select to the original value
                        $(this).val('{{ $status }}');
                    }
                }
            });
        });
    });

    function markAsCompleted() {
        Swal.fire({
            title: 'Mark as Completed?',
            text: 'Are you sure you want to mark this order as completed?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, mark as completed!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = new FormData();
                formData.append('order_id', '{{ $order_id }}');
                formData.append('status', 'completed');
                formData.append('_token', '{{ csrf_token() }}');
        
                $.ajax({
                    url: "{{ route('technician.orders.updateStatus') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Completed!',
                            text: 'Order marked as completed successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (xhr) {
                        if (xhr.status === 403) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Unauthorized',
                                text: 'You are not authorized to update this order status. This order is not assigned to you.'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update status.'
                            });
                        }
                    }
                });
            }
        });
    }

    function cancelOrder() {
        $('#cancellation_reason').val('');
        $('#charCount').text('0');
        $('#cancelOrderModal').modal('show');
    }

    function submitCancellation() {
        const reason = $('#cancellation_reason').val().trim();
        
        if (reason.length < 10) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Reason',
                text: 'Please provide a cancellation reason with at least 10 characters.'
            });
            return;
        }
        
        Swal.fire({
            title: 'Cancel Order?',
            text: 'Are you sure you want to cancel this order? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = new FormData();
                formData.append('order_id', '{{ $order_id }}');
                formData.append('cancellation_reason', reason);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('technician.orders.cancel') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#cancelOrderModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Cancelled!',
                            text: 'Order cancelled successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (xhr) {
                        if (xhr.status === 403) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Unauthorized',
                                text: 'You are not authorized to cancel this order.'
                            });
                        } else if (xhr.status === 400) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Invalid Action',
                                text: 'Only pending orders can be cancelled.'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to cancel order. Please try again.'
                            });
                        }
                    }
                });
            }
        });
    }

    // Character counter for cancellation reason
    $(document).ready(function() {
        $('#cancellation_reason').on('input', function() {
            const length = $(this).val().length;
            $('#charCount').text(length);
            
            if (length > 450) {
                $('#charCount').addClass('text-warning');
            } else {
                $('#charCount').removeClass('text-warning');
            }
            
            if (length > 480) {
                $('#charCount').removeClass('text-warning').addClass('text-danger');
            } else if (length <= 450) {
                $('#charCount').removeClass('text-danger');
            }
        });
    });
    </script>
