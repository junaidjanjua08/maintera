@extends('index')

@section('content')
<!-- Include Google Maps API Script -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initAutocomplete&libraries=places&v=weekly" defer></script>

<!-- Booking Page Start -->
<div class="container-xxl py-5">
    <div class="container">
        <!-- Service Info -->
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold text-primary">{{ $service->name }}</h1>
            <p class="lead text-muted">{{ $service->description }}</p>
        </div>

        <!-- Booking Form Card -->
        <div class="card shadow-lg border-0">
            <div class="card-body p-5">
                <h3 class="text-center text-secondary mb-4">Book Your Service</h3>

                <form action="{{ route('service.order') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <!-- Address Section -->
                        <div class="col-md-6">
                            <div class="bg-light p-4 rounded shadow-sm h-100">
                                <h5 class="text-primary mb-3">Address Details</h5>

                                <div class="form-group mb-3">
                                    <label for="user_address" class="form-label">Street Address</label>
                                    <input id="user_address" name="street_adress" type="text" class="form-control" placeholder="Enter street address">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" name="city" id="city" class="form-control" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="area" class="form-label">Area</label>
                                    <input type="text" name="area" id="area" class="form-control" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="sub_area" class="form-label">Sub Area</label>
                                    <input type="text" id="sub_area" name="sub_area" class="form-control" readonly>
                                </div>

                                <input type="hidden" id="lat_route">
                                <input type="hidden" id="lng_route">
                                <input type="hidden" name="category_id" value="{{ $service->category_id }}">
                                <input type="hidden" name="subcategory_id" value="{{ $service->id }}">
                                
                            </div>
                        </div>

                        <!-- Date and Time Section -->
                        <div class="col-md-6">
                            <div class="bg-light p-4 rounded shadow-sm h-100">
                                <h5 class="text-primary mb-3">Date and Time</h5>
                                <div class="form-group mb-3">
                                    <label for="date" class="form-label">Select Date</label>
                                    <input type="date" id="date" name="date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="time" class="form-label">Select Time</label>
                                    <input type="time" id="time" name="time" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="col-md-12">
                            <div class="bg-light p-4 rounded shadow-sm">
                                <h5 class="text-primary mb-3">Payment Method</h5>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment_method" id="creditCard" value="online" required>
                                    <label class="form-check-label" for="creditCard">
                                        Credit Card
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" required>
                                    <label class="form-check-label" for="cash">
                                        Cash on Delivery
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Service Description -->
                        <div class="col-md-12">
                            <div class="bg-light p-4 rounded shadow-sm">
                                <h5 class="text-primary mb-3">Service Description</h5>
                                <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter any additional details about your service..."></textarea>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-lg btn-primary px-5 shadow-sm">
                                Confirm Booking
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
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

    let address1 = ""; // Full address
    let city = "";
    let area = "";
    let subArea = "";

    // Loop through the address components and fill in the fields
    for (const component of place.address_components) {
        const componentType = component.types[0];

        switch (componentType) {
            case "street_number":
                address1 = `${component.long_name} ${address1}`; // Prepend street number
                break;
            case "route":
                address1 += component.short_name; // Append street name (route)
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

    // Build the full address string
    address1 = `${address1.trim()}, ${area.trim()}, ${subArea.trim()}, ${city.trim()}`.trim();

    // Check the final address output in the console for debugging
    console.log("Full Address: ", address1); // For debugging
    console.log("City: ", city);
    console.log("Area: ", area);
    console.log("SubArea: ", subArea);

    // Ensure the address is properly formatted and stored in address1Field
    address1Field.value = address1; // Full address in user_address field
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
