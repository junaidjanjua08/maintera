@extends('index')

@section('content')

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
                    <div class="form-group">
                        <label for="city">City</label>
                        <select id="city" name="city" class="form-control" required>
                            <option value="">Select a City</option>
                            <option value="Islamabad">Islamabad</option>
                            <option value="Lahore">Lahore</option>
                            <option value="Karachi">Karachi</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="area">Area</label>
                        <select id="area" name="area" class="form-control" required>
                            <option value="">Select Area</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="street">Street Address</label>
                        <input type="text" id="street" name="street" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <button type="button" id="useLocationBtn" onclick="useCurrentLocation()" class="btn btn-secondary">Use Current Location</button>
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

@endsection

<!-- Include Google Maps API Script -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initAutocomplete&libraries=places&loading=async&v=weekly" defer></script>

<script>
    let autocomplete;
    let addressField;
    let useLocationBtn = document.getElementById('useLocationBtn');
    let cityDropdown = document.getElementById('city');
    let areaDropdown = document.getElementById('area');
    let streetField = document.getElementById('street');

    // Initialize Google Maps Autocomplete
    function initAutocomplete() {
        addressField = streetField;

        // Setup the autocomplete on the address field (street address)
        autocomplete = new google.maps.places.Autocomplete(addressField, {
            types: ['geocode'],  // Restrict to geocode (places with a physical address)
            componentRestrictions: { country: 'US' }  // Adjust the country as needed
        });

        // Add listener to handle the place selection
        autocomplete.addListener('place_changed', function() {
            let place = autocomplete.getPlace();

            if (!place.geometry) {
                return;
            }

            // Handle the selected place
            console.log('Selected place:', place);
        });
    }

    // Call this function in the script tag in your layout as part of the script URL
    window.initAutocomplete = initAutocomplete;

    // Function to get current location
  // Function to use the current location
 
  function useCurrentLocation() {
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
              const lat = position.coords.latitude;
              const lng = position.coords.longitude;

              // Use Google Maps Geocoder to get address from lat/lng
              const geocoder = new google.maps.Geocoder();
              const latLng = new google.maps.LatLng(lat, lng);

              geocoder.geocode({ 'location': latLng }, function(results, status) {
                  if (status === google.maps.GeocoderStatus.OK) {
                      if (results[0]) {
                          let city = '';
                          let area = '';
                          let street = results[0].formatted_address;

                          // Loop through address components and extract city, area, and street
                          results[0].address_components.forEach(function(component) {
                              if (component.types.includes("locality")) {
                                  city = component.long_name;
                              } else if (component.types.includes("neighborhood")) {
                                  area = component.long_name;
                              }
                          });

                          // Check if the city is one of the static cities (Islamabad, Lahore, Karachi)
                          if (city === 'Islamabad' || city === 'Lahore' || city === 'Karachi') {
                              // Fill in city, area, and street fields
                              document.getElementById('city').value = city;
                              document.getElementById('area').value = area;
                              document.getElementById('street').value = street;
                          } else {
                              alert('Current location is not within the allowed cities (Islamabad, Lahore, Karachi).');
                          }
                      }
                  } else {
                      alert('Geocoder failed due to: ' + status);
                  }
              });
          }, function(error) {
              if (error.code === error.PERMISSION_DENIED) {
                  alert('Geolocation permission denied. Please allow location access.');
              }
          });
      } else {
          alert('Geolocation is not supported by this browser.');
      }
  }

 
    document.getElementById('city').addEventListener('change', function () {
        const selectedCity = this.value;
        const areaDropdown = document.getElementById('area');

        areaDropdown.innerHTML = '<option value="">Loading...</option>';

        if (!selectedCity) {
            areaDropdown.innerHTML = '<option value="">Select Area</option>';
            return;
        }

        fetch(`/api/areas?city=${encodeURIComponent(selectedCity)}`)
            .then(response => response.json())
            .then(areas => {
                areaDropdown.innerHTML = '<option value="">Select Area</option>';
                areas.forEach(area => {
                    const option = document.createElement('option');
                    option.value = area;
                    option.text = area;
                    areaDropdown.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching areas:', error);
                areaDropdown.innerHTML = '<option value="">Error loading areas</option>';
            });
    });




    // Event listener for the "Use Current Location" button
    // useLocationBtn.addEventListener('click', useCurrentLocation);
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

    .btn-secondary {
        border-radius: 50px;
        padding: 10px 30px;
        margin-top: 15px;
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
