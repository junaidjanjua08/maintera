@extends('index')

@section('content')

<!-- Booking Page Start -->
<div class="container-xxl py-5">
    <div class="container">
        <h1 class="text-center mb-5">Book Your Service</h1>

        <!-- Form for booking details -->
        <form action="/submit-booking" method="POST">
            @csrf
            <div class="row g-4">
                
                <!-- Address Section -->
                <div class="col-md-6">
                    <h5>Address Details</h5>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="area">Area</label>
                        <input type="text" id="area" name="area" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="street">Street Address</label>
                        <input type="text" id="street" name="street" class="form-control" required>
                    </div>
                </div>

                <!-- Date and Time Section -->
                <div class="col-md-6">
                    <h5>Date and Time</h5>
                    <div class="form-group">
                        <label for="date">Select Date</label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="time">Select Time</label>
                        <input type="time" id="time" name="time" class="form-control" required>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="col-md-12 mt-5">
                    <h5>Payment Method</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="creditCard" value="credit_card" required>
                        <label class="form-check-label" for="creditCard">
                            Credit Card
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" required>
                        <label class="form-check-label" for="cash">
                            Cash on Delivery
                        </label>
                    </div>
                </div>

                <!-- Service Description -->
                <div class="col-md-12 mt-5">
                    <h5>Service Description</h5>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter any additional details about your service..."></textarea>
                </div>

                <!-- Submit Button -->
                <div class="col-12 mt-5 text-center">
                    <button type="submit" class="btn btn-primary">Confirm Booking</button>
                </div>

            </div>
        </form>
    </div>
</div>
<!-- Booking Page End -->



<!-- Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addressModalLabel">Enter Address Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="address-form">
            <div class="form-group">
              <label for="modal-city">City</label>
              <input type="text" id="modal-city" class="form-control" required>
            </div>
            <div class="form-group mt-3">
              <label for="modal-area">Area</label>
              <input type="text" id="modal-area" class="form-control" required>
            </div>
            <div class="form-group mt-3">
              <label for="modal-street">Street Address</label>
              <input type="text" id="modal-street" class="form-control" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="populateAddress()">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  
  <script>
      // Function to populate form fields from modal inputs
      function populateAddress() {
          document.getElementById('city').value = document.getElementById('modal-city').value;
          document.getElementById('area').value = document.getElementById('modal-area').value;
          document.getElementById('street').value = document.getElementById('modal-street').value;
      }
      
      // Open the modal on page load
      window.onload = function() {
          var addressModal = new bootstrap.Modal(document.getElementById('addressModal'), {});
          addressModal.show();
      };
  </script>
  

@endsection

<style>
    .form-control {
        border-radius: 10px;
        padding: 15px;
    }

    .btn-primary {
        border-radius: 50px;
        padding: 10px 30px;
    }

    h5 {
        margin-bottom: 20px;
        font-size: 1.25rem;
        font-weight: bold;
    }

    textarea {
        resize: none;
    }
</style>
