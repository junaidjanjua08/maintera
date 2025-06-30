@extends('index')

@section('content')
    <div class="container-xxl py-5">
        <div class="container">
            <!-- Service Header -->
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary">{{ $service->name }}</h1>
                <p class="lead text-muted">{{ $service->description }}</p>
            </div>

            <!-- Booking Form -->
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h3 class="text-center text-secondary mb-4">Book Your Service</h3>

                    <form action="{{ route('service.order') }}" method="POST" id="bookingForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">

                            <!-- Address Section -->
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Your Address</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-4">
                                            <label for="address" class="form-label required-field">Complete Address</label>
                                            <div class="position-relative">
                                                <input type="text"
                                                    class="form-control border border-primary @error('address') is-invalid @enderror"
                                                    id="address" name="address" value="{{ old('address') }}"
                                                    placeholder="Start typing your address..." required>
                                                <i
                                                    class="fas fa-map-marker-alt position-absolute top-50 end-0 translate-middle-y pe-3 text-muted"></i>
                                            </div>
                                            <div class="text-center mt-2">OR</div>
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-outline-primary w-100 w-md-auto"
                                                    id="useCurrentLocation">
                                                    <i class="fas fa-location-arrow text-warning"></i> Use Current Location
                                                </button>
                                            </div>

                                            @error('address')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Hidden Fields for Address Details -->
                                        <input type="hidden" id="street_number" name="street_number"
                                            value="{{ old('street_number') }}">
                                        <input type="hidden" id="route" name="route" value="{{ old('route') }}">
                                        <input type="hidden" id="locality" name="locality" value="{{ old('locality') }}">
                                        <input type="hidden" id="administrative_area_level_1" name="state"
                                            value="{{ old('state') }}">
                                        <input type="hidden" id="postal_code" name="postal_code"
                                            value="{{ old('postal_code') }}">
                                        <input type="hidden" id="country" name="country" value="Pakistan">
                                        <input type="hidden" id="latitude" name="lat_route"
                                            value="{{ old('latitude') }}">
                                        <input type="hidden" id="longitude" name="lng_route"
                                            value="{{ old('longitude') }}">
                                        <input type="hidden" id="area" name="area" value="{{ old('area') }}">

                                        <!-- Address Preview -->
                                        <div id="address-preview" class="mt-3" style="display:none;">
                                            <p><strong>Selected Address:</strong> <span id="selected-address"></span></p>
                                            <p><strong>City:</strong> <span id="selected-city"></span></p>
                                            <p><strong>State:</strong> <span id="selected-state"></span></p>
                                            <p><strong>Postal Code:</strong> <span id="selected-postal-code"></span></p>
                                            <p><strong>Area:</strong> <span id="selected-area"></span></p>
                                            <p><strong>Latitude:</strong> <span id="selected-latitude"></span></p>
                                            <p><strong>Longitude:</strong> <span id="selected-longitude"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Date & Time -->
                            <div class="col-md-6">
                                <div class="bg-light p-4 rounded shadow-sm h-100">
                                    <h5 class="text-primary mb-3">Date and Time</h5>
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Select Date</label>
                                        <input type="date" id="date" name="date"
                                            class="form-control border border-primary" required>
                                    </div>
                                    <div>
                                        <label for="time" class="form-label">Select Time</label>
                                        <input type="time" id="time" name="time"
                                            class="form-control border border-primary" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="col-md-6">
                                <div class="bg-light p-4 rounded shadow-sm h-100">
                                    <h5 class="text-primary mb-3">Payment Method</h5>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="creditCard" value="online" required>
                                        <label class="form-check-label" for="creditCard">Online Banking</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="cash" value="cash" required>
                                        <label class="form-check-label" for="cash">Cash on Delivery</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12">
                                <div class="bg-light p-4 rounded shadow-sm">
                                    <h5 class="text-primary mb-3">Service Description</h5>
                                    <textarea name="description" class="form-control border border-primary" rows="4"
                                        placeholder="Any additional info...">{{ old('description') }}</textarea>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="bg-light p-4 rounded shadow-sm">
                                    <h5 class="text-primary mb-3">Upload Images/Videos (Optional)</h5>

                                    <!-- Upload from device -->
                                    <input type="file" name="media_files[]" accept="image/*,video/*" multiple
                                        class="form-control border border-primary mb-3" id="mediaUpload">

                                    <!-- Capture photo from mobile camera -->
                                    <label for="cameraCapture" class="btn btn-outline-primary mb-3">
                                        <i class="fas fa-camera"></i> Capture Photo
                                    </label>
                                    <input type="file" accept="image/*,video/*" capture="user" id="cameraCapture"
                                        name="camera_capture" style="display:none;">

                                    <!-- Preview area -->
                                    <div id="mediaPreview" class="d-flex flex-wrap gap-3"></div>
                                </div>
                            </div>




                            <!-- Hidden Service Info -->
                            <input type="hidden" name="category_id" value="{{ $service->category_id }}">
                            <input type="hidden" name="subcategory_id" value="{{ $service->id }}">

                            <!-- Submit -->
                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn btn-lg btn-primary px-5 shadow-sm">Confirm
                                    Booking</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Optional: stop stream on page unload or on demand
        window.addEventListener('beforeunload', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });

        // Preview selected media files (images/videos)
        document.getElementById('mediaUpload').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('mediaPreview');
            // append previews, don't clear to allow multiple previews
            const files = event.target.files;
            if (!files.length) return;

            Array.from(files).forEach(file => {
                const fileType = file.type;
                const reader = new FileReader();

                reader.onload = function(e) {
                    let element;
                    if (fileType.startsWith('image/')) {
                        element = document.createElement('img');
                        element.src = e.target.result;
                        element.style.maxWidth = '150px';
                        element.style.maxHeight = '150px';
                        element.classList.add('rounded', 'border');
                    } else if (fileType.startsWith('video/')) {
                        element = document.createElement('video');
                        element.src = e.target.result;
                        element.controls = true;
                        element.style.maxWidth = '150px';
                        element.style.maxHeight = '150px';
                        element.classList.add('rounded', 'border');
                    }
                    previewContainer.appendChild(element);
                };

                reader.readAsDataURL(file);
            });
        });

        // Preview captured photo/video from mobile camera input
        document.getElementById('cameraCapture').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('mediaPreview');
            // append preview, don't clear existing previews
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                let element;
                if (file.type.startsWith('image/')) {
                    element = document.createElement('img');
                } else if (file.type.startsWith('video/')) {
                    element = document.createElement('video');
                    element.controls = true;
                }
                if (element) {
                    element.src = e.target.result;
                    element.style.maxWidth = '150px';
                    element.style.maxHeight = '150px';
                    element.classList.add('rounded', 'border');
                    previewContainer.appendChild(element);
                }
            };
            reader.readAsDataURL(file);
        });



        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Google Places Autocomplete
        function initAutocomplete() {
            const addressInput = document.getElementById('address');
            const options = {
                componentRestrictions: {
                    country: 'pk'
                }, // Restrict to Pakistan
                fields: ['address_components', 'formatted_address', 'geometry', 'name'],
                types: ['address']
            };

            const autocomplete = new google.maps.places.Autocomplete(addressInput, options);

            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                if (!place.address_components) return;

                // Clear previous values
                document.getElementById('street_number').value = '';
                document.getElementById('route').value = '';
                document.getElementById('locality').value = '';
                document.getElementById('administrative_area_level_1').value = '';
                document.getElementById('postal_code').value = '';
                document.getElementById('latitude').value = '';
                document.getElementById('longitude').value = '';
                document.getElementById('area').value = '';

                // Get address components
                for (const component of place.address_components) {
                    const componentType = component.types[0];

                    switch (componentType) {
                        case 'street_number':
                            document.getElementById('street_number').value = component.long_name;
                            break;
                        case 'route':
                            document.getElementById('route').value = component.long_name;
                            break;
                        case 'locality':
                            document.getElementById('locality').value = component.long_name;
                            document.getElementById('selected-city').textContent = component.long_name;
                            break;
                        case 'administrative_area_level_1':
                            document.getElementById('administrative_area_level_1').value = component.long_name;
                            document.getElementById('selected-state').textContent = component.long_name;
                            break;
                        case 'postal_code':
                            document.getElementById('postal_code').value = component.long_name;
                            document.getElementById('selected-postal-code').textContent = component.long_name;
                            break;
                        case 'sublocality_level_1':
                            document.getElementById('area').value = component.long_name;
                            document.getElementById('selected-area').textContent = component.long_name;
                            break;
                    }
                }

                // Get coordinates
                if (place.geometry && place.geometry.location) {
                    const lat = place.geometry.location.lat();
                    const lng = place.geometry.location.lng();

                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                    document.getElementById('selected-latitude').textContent = lat.toFixed(6);
                    document.getElementById('selected-longitude').textContent = lng.toFixed(6);
                }

                // Update preview
                document.getElementById('selected-address').textContent = place.formatted_address;
                document.getElementById('address-preview').style.display = 'block';
            });
        }


        // for currnt location
        document.getElementById('useCurrentLocation').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
            } else {
                alert('Geolocation is not supported by this browser.');
            }

            function successCallback(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                // Set Lat/Lng
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                document.getElementById('selected-latitude').textContent = lat.toFixed(6);
                document.getElementById('selected-longitude').textContent = lng.toFixed(6);

                // Geocode the coordinates
                const geocoder = new google.maps.Geocoder();
                const latlng = {
                    lat: lat,
                    lng: lng
                };

                geocoder.geocode({
                    location: latlng
                }, function(results, status) {
                    if (status === 'OK' && results[0]) {
                        const place = results[0];
                        document.getElementById('address').value = place.formatted_address;
                        document.getElementById('selected-address').textContent = place.formatted_address;
                        document.getElementById('address-preview').style.display = 'block';

                        // Reset all fields first
                        document.getElementById('street_number').value = '';
                        document.getElementById('route').value = '';
                        document.getElementById('locality').value = '';
                        document.getElementById('administrative_area_level_1').value = '';
                        document.getElementById('postal_code').value = '';
                        document.getElementById('area').value = '';

                        // Loop through address components
                        for (const component of place.address_components) {
                            const type = component.types[0];
                            switch (type) {
                                case 'street_number':
                                    document.getElementById('street_number').value = component.long_name;
                                    break;
                                case 'route':
                                    document.getElementById('route').value = component.long_name;
                                    break;
                                case 'locality':
                                    document.getElementById('locality').value = component.long_name;
                                    document.getElementById('selected-city').textContent = component
                                        .long_name;
                                    break;
                                case 'administrative_area_level_1':
                                    document.getElementById('administrative_area_level_1').value = component
                                        .long_name;
                                    document.getElementById('selected-state').textContent = component
                                        .long_name;
                                    break;
                                case 'postal_code':
                                    document.getElementById('postal_code').value = component.long_name;
                                    document.getElementById('selected-postal-code').textContent = component
                                        .long_name;
                                    break;
                                case 'sublocality_level_1':
                                    document.getElementById('area').value = component.long_name;
                                    document.getElementById('selected-area').textContent = component
                                        .long_name;
                                    break;
                            }
                        }
                    } else {
                        alert('Unable to retrieve address. Try again.');
                    }
                });
            }

            function errorCallback(error) {
                alert('Geolocation error: ' + error.message);
            }
        });
    </script>
@endsection
