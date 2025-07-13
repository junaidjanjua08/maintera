@extends('technician.index')

@section('content')
<style>
    body {
        background: #f9fafb;
    }

    .order-card {
        background: #ffffff;
        border: none;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .order-title {
        font-weight: 700;
        font-size: 1.25rem;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .order-desc {
        font-size: 0.95rem;
        color: #4b5563;
    }

    .order-location {
        font-size: 0.75rem;
        font-weight: 600;
        background: #e0f2fe;
        color: #0369a1;
        padding: 6px 14px;
        border-radius: 9999px;
        display: inline-block;
        margin-bottom: 10px;
    }

    .view-btn {
        font-size: 0.85rem;
        padding: 8px 16px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(to right, #facc15, #eab308);
        color: #1f2937;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 10px rgba(234, 179, 8, 0.2);
    }

    .view-btn:hover {
        background: linear-gradient(to right, #eab308, #ca8a04);
        box-shadow: 0 6px 15px rgba(202, 138, 4, 0.3);
    }

    .order-badge {
        position: absolute;
        top: 0;
        right: 0;
        font-size: 0.75rem;
        font-weight: bold;
        padding: 6px 14px;
        border-radius: 0 16px 0 16px;
        color: white;
    }

    .badge-pending {
        background: #facc15;
        color: #1f2937;
    }

    h2 {
        font-weight: 700;
        font-size: 1.8rem;
        color: #1f2937;
        margin-bottom: 2rem;
    }

    .btn {
        transition: all 0.3s ease-in-out;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-danger:hover {
        background: #c82333 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(220, 53, 69, 0.4);
    }

    .gap-2 {
        gap: 0.5rem !important;
    }

    @media (max-width: 576px) {
        .d-flex.flex-column.flex-sm-row {
            flex-direction: column !important;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .text-end {
            text-align: center !important;
        }
    }
</style>

<div class="row">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>⏳ Pending Orders</h2>
            <small class="text-muted">
                <i class="fas fa-info-circle"></i> 
                You can cancel orders that are in pending state. Cancellation requires a reason and will notify the customer.
            </small>
        </div>
        <span class="badge bg-success text-white px-3 py-2" style="border-radius: 12px; font-size: 0.9rem;">
            {{ count($pending_orders) }} Orders Pending
        </span>
    </div>
    @if(count($pending_orders) == 0)
    <div class="col-12">
        <div class="alert alert-info text-center">
            <i class="fe fe-info fs-3 mb-2"></i>
            <h5>No Pending Orders </h5>
            <p class="mb-0">You don't have any pending orders at the moment.</p>
            <small class="text-muted">Orders will appear here when customers accept your fare offer.</small>
        </div>
    </div>
@endif
    @foreach ($pending_orders as $order)
    <div class="col-md-12 mb-4">
        <div class="order-card">
            <div class="order-badge badge-new">New</div>
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="me-3">
                    <div class="order-title">{{ $order->order->subcategory->name }}</div>
                    <div class="order-desc">{{ $order->order->description }}</div>
                </div>
                <div class="text-end mt-3 mt-md-0">
                    <div class="order-location mb-3">{{ $order->order->area . $order->order->city }}</div>

                    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end">
                        <form method="POST" action="{{ route('technician.order.view') }}" class="d-inline">
                            @csrf
                            <input type="hidden" name="subcategory_name" value="{{ $order->order->subcategory->name }}">
                            <input type="hidden" name="description" value="{{ $order->order->description }}">
                            <input type="hidden" name="area" value="{{ $order->order->area }}">
                            <input type="hidden" name="order_id" value="{{ $order->order->id }}">
                            <input type="hidden" name="city" value="{{ $order->order->city }}">
                            <input type="hidden" name="customer_name" value="{{ $order->order->customer->name }}">
                            <input type="hidden" name="email" value="{{ $order->order->customer->email }}">
                            <input type="hidden" name="phone" value="{{ $order->order->customer->phone }}">
                            <input type="hidden" name="address" value="{{ $order->order->street_address }}">
                            <input type="hidden" name="status" value="{{ $order->order->status }}">
                            <input type="hidden" name="route" value="{{ route('technician.orders.pending') }}">
                            
                            <button type="submit" class="view-btn">View Order</button>
                        </form>
                        
                        <!-- Chat Button -->
                        @if($order->order->technician_id == auth()->id())
                            <a href="{{ route('technician.chat.show', $order->order) }}" class="btn btn-primary" style="background: linear-gradient(to right, #3b82f6, #1d4ed8); border: none; border-radius: 12px; padding: 8px 16px; font-size: 0.85rem; box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);">
                                <i class="fas fa-comments"></i> Chat
                            </a>
                        @endif
                        
                        <!-- Mark as Completed Button -->
                        <button onclick="markAsCompleted({{ $order->order->id }})" class="btn btn-success" style="border: none; border-radius: 12px; padding: 8px 16px; font-size: 0.85rem; box-shadow: 0 2px 4px rgba(40, 167, 69, 0.2);">
                            <i class="fas fa-check"></i> Complete
                        </button>
                        
                        <!-- Cancel Order Button -->
                        <button onclick="cancelOrder({{ $order->order->id }})" class="btn btn-danger" style="border: none; border-radius: 12px; padding: 8px 16px; font-size: 0.85rem; box-shadow: 0 2px 4px rgba(220, 53, 69, 0.2); transition: all 0.3s ease;">
                            <i class="fas fa-times"></i> Cancel Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

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
                    <input type="hidden" id="cancelOrderId" name="order_id">
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

<script>
function markAsCompleted(orderId) {
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
            formData.append('order_id', orderId);
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

function cancelOrder(orderId) {
    $('#cancelOrderId').val(orderId);
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
            formData.append('order_id', $('#cancelOrderId').val());
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
@endsection
