@extends('index')

@section('content')
<!-- Include Google Maps API Script -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
<!-- Booking Page Start -->
<div class="container-xxl py-5">
    <div class="container">
        <!-- Displaying Service Details -->
        <h1 class="text-center mb-5">{{ $service->name }}</h1>
        <p class="text-center">{{ $service->description }}</p>

        <h3 class="text-center mb-5">Book Your Service</h3>

        <!-- Form for booking details -->
        <form action="/submit-booking" method="POST">
            @csrf
            <div class="row g-4">
                
                <!-- Address Section -->
                <div class="col-md-6">
                    <h5>Address Details</h5>

                    <!-- Street Address Field -->
                    <div class="form-group">
                        <label for="user_address">Street Address</label>
                        <input id="user_address" type="text" class="form-control" placeholder="Enter street address">
                    </div>
                    
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" class="form-control" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="area">Area</label>
                        <input type="text" id="area" class="form-control" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="sub_area">Sub Area</label>
                        <input type="text" id="sub_area" class="form-control" readonly>
                    </div>
                    
                    <input type="hidden" id="lat_route">
                    <input type="hidden" id="lng_route">
                    
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

@endsection




<script>
    let autocomplete;
    let address1Field;
    let cityField;
    let areaField;
    let subAreaField;
    let lat_route;
    let lng_route;

    // Initialize the Google Places Autocomplete API
    function initAutocomplete() {
        address1Field = document.querySelector("#user_address");
        cityField = document.querySelector("#city");
        areaField = document.querySelector("#area");
        subAreaField = document.querySelector("#sub_area");
        lat_route = document.querySelector("#lat_route");
        lng_route = document.querySelector("#lng_route");

        autocomplete = new google.maps.places.Autocomplete(address1Field, {
            fields: ["address_components", "geometry"],
            types: ["geocode"],
        });

        // Listen to place changed event
        autocomplete.addListener("place_changed", fillInAddress);
    }

    // Fill in the form fields when an address is selected
    function fillInAddress() {
        const place = autocomplete.getPlace();
        
        if (!place.geometry) {
            console.log("Place has no geometry");
            return;
        }

        // Get latitude and longitude from the selected place
        let latitude = place.geometry.location.lat();
        let longitude = place.geometry.location.lng();
        lat_route.value = latitude;
        lng_route.value = longitude;

        let address1 = "";
        let city = "";
        let area = "";
        let subArea = "";

        // Loop through the address components and fill in the fields
        for (const component of place.address_components) {
            const componentType = component.types[0];

            switch (componentType) {
                case "street_number":
                    address1 = `${component.long_name} ${address1}`;
                    break;
                case "route":
                    address1 += component.short_name;
                    break;
                case "locality": // City
                    city = component.long_name;
                    break;
                case "sublocality_level_1": // Area
                    area = component.long_name;
                    break;
                case "sublocality_level_2": // Sub Area
                    subArea = component.long_name;
                    break;
                case "country": // Country (optional)
                    break;
            }
        }

        // Set the values in the respective fields
        address1Field.value = address1;
        cityField.value = city;
        areaField.value = area;
        subAreaField.value = subArea;
    }

    window.initAutocomplete = initAutocomplete;
</script>



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
