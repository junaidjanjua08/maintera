@extends('technician.index')
@section('content')
<style>
    .profile-section {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    .profile-section:hover {
        box-shadow: 0 0 30px rgba(0,0,0,0.1);
    }
    .section-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 1.5rem;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #e3e6f0;
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78,115,223,0.25);
    }
    .form-label {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 0.5rem;
    }
    .required-field::after {
        content: " *";
        color: #e74a3b;
    }
    .profile-image-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #4e73df;
        padding: 3px;
        background: white;
    }
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }
    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
    }
    .custom-upload-btn {
        border: 2px solid #4e73df;
        color: #4e73df;
        background-color: white;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .custom-upload-btn:hover {
        background-color: #4e73df;
        color: white;
    }
    .submit-btn {
        background: linear-gradient(45deg, #4e73df, #224abe);
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(78,115,223,0.3);
    }
    .form-section {
        padding: 2rem;
    }
    .help-text {
        color: #858796;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }
    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }
    .card-header {
        border-bottom: none;
        padding: 1.5rem;
    }
    .form-check-input:checked {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    .pac-container {
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        margin-top: 5px;
    }
    .pac-item {
        padding: 8px 12px;
        font-size: 14px;
    }
    .pac-item:hover {
        background-color: #f8f9fc;
    }
    .address-input-wrapper {
        position: relative;
    }
    .address-input-wrapper .form-control {
        padding-right: 40px;
    }
    .address-input-wrapper .location-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #4e73df;
    }
    .address-details {
        background: #f8f9fc;
        border-radius: 8px;
        padding: 15px;
        margin-top: 10px;
    }
    .address-details p {
        margin-bottom: 5px;
        color: #5a5c69;
    }
    .address-details strong {
        color: #4e73df;
    }
    .occupation-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }
    .occupation-option {
        position: relative;
        border: 2px solid #e3e6f0;
        border-radius: 12px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fff;
    }
    .occupation-option:hover {
        border-color: #4e73df;
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.15);
        transform: translateY(-2px);
    }
    .occupation-checkbox {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    .occupation-checkbox:checked + .occupation-label {
        color: #4e73df;
    }
    .occupation-checkbox:checked ~ .occupation-option {
        border-color: #4e73df;
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
    }
    .occupation-label {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: #5a5c69;
        margin: 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .occupation-label i {
        margin-right: 12px;
        font-size: 1.2rem;
        color: #858796;
        transition: all 0.3s ease;
    }
    .occupation-checkbox:checked + .occupation-label i {
        color: #4e73df;
        transform: scale(1.1);
    }
    .occupation-option.selected {
        border-color: #4e73df;
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.2);
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card profile-section">
                <div class="section-header">
                    <h4 class="mb-0">Complete Your Professional Profile</h4>
                    <p class="mb-0 mt-2">Fill in your details to create a professional profile</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('technician.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Profile Picture Section -->
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Profile Picture</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="mb-4">
                                            <img src="{{ $profile->profile_image ? asset($profile->profile_image) : asset('images/default-profile.png') }}" 
                                                 alt="Profile Preview" 
                                                 class="profile-image-preview" 
                                                 id="profile-preview">
                                        </div>
                                        <div class="upload-btn-wrapper">
                                            <button class="custom-upload-btn">
                                                <i class="fas fa-camera me-2"></i>Choose Photo
                                            </button>
                                            <input type="file" 
                                                   class="form-control @error('profile_image') is-invalid @enderror" 
                                                   id="profile_image" 
                                                   name="profile_image" 
                                                   accept="image/*"
                                                   onchange="previewImage(this)">
                                        </div>
                                        <p class="help-text mt-2">Upload a professional photo of yourself (Max size: 2MB)</p>
                                        @error('profile_image')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Information -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Personal Information</h5>
                                    </div>
                                    <div class="form-section">
                                        <div class="form-group mb-4">
                                            <label for="name" class="form-label required-field">Full Name</label>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name', $user->name ?? '') }}" 
                                                   placeholder="Enter your full name" 
                                                   required>
                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="email" class="form-label required-field">Email Address</label>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $user->email ?? '') }}" 
                                                   placeholder="Enter your email address" 
                                                   required>
                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="phone" class="form-label required-field">Phone Number</label>
                                            <input type="tel" 
                                                   class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" 
                                                   name="phone" 
                                                   value="{{ old('phone', $profile->phone ?? '') }}" 
                                                   placeholder="Enter your 10-digit mobile number" 
                                                   required>
                                            @error('phone')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Professional Information -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Professional Information</h5>
                                    </div>
                                    <div class="form-section">
                                        <div class="form-group mb-4">
                                            <label class="form-label required-field">What type of technician are you?</label>
                                            <div class="occupation-grid">
                                                @php
                                                    $occupations = old('occupation', $profile->occupation ?? []);
                                                    if (!is_array($occupations)) {
                                                        $occupations = [];
                                                    }
                                                @endphp
                                                
                                                <div class="occupation-option">
                                                    <input type="checkbox" id="occupation_electrician" name="occupation[]" value="Electrician" 
                                                           {{ in_array('Electrician', $occupations) ? 'checked' : '' }} class="occupation-checkbox">
                                                    <label for="occupation_electrician" class="occupation-label">
                                                        <i class="fas fa-bolt"></i>
                                                        <span>Electrician</span>
                                                    </label>
                                                </div>
                                                
                                                <div class="occupation-option">
                                                    <input type="checkbox" id="occupation_plumber" name="occupation[]" value="Plumber" 
                                                           {{ in_array('Plumber', $occupations) ? 'checked' : '' }} class="occupation-checkbox">
                                                    <label for="occupation_plumber" class="occupation-label">
                                                        <i class="fas fa-tint"></i>
                                                        <span>Plumber</span>
                                                    </label>
                                                </div>
                                                
                                                <div class="occupation-option">
                                                    <input type="checkbox" id="occupation_painter" name="occupation[]" value="Painter" 
                                                           {{ in_array('Painter', $occupations) ? 'checked' : '' }} class="occupation-checkbox">
                                                    <label for="occupation_painter" class="occupation-label">
                                                        <i class="fas fa-paint-brush"></i>
                                                        <span>Painter</span>
                                                    </label>
                                                </div>
                                                
                                                <div class="occupation-option">
                                                    <input type="checkbox" id="occupation_carpenter" name="occupation[]" value="Carpenter" 
                                                           {{ in_array('Carpenter', $occupations) ? 'checked' : '' }} class="occupation-checkbox">
                                                    <label for="occupation_carpenter" class="occupation-label">
                                                        <i class="fas fa-hammer"></i>
                                                        <span>Carpenter</span>
                                                    </label>
                                                </div>
                                                
                                                <div class="occupation-option">
                                                    <input type="checkbox" id="occupation_housekeeping" name="occupation[]" value="Housekeeping" 
                                                           {{ in_array('Housekeeping', $occupations) ? 'checked' : '' }} class="occupation-checkbox">
                                                    <label for="occupation_housekeeping" class="occupation-label">
                                                        <i class="fas fa-home"></i>
                                                        <span>Housekeeping</span>
                                                    </label>
                                                </div>
                                                
                                                <div class="occupation-option">
                                                    <input type="checkbox" id="occupation_other" name="occupation[]" value="Other" 
                                                           {{ in_array('Other', $occupations) ? 'checked' : '' }} class="occupation-checkbox">
                                                    <label for="occupation_other" class="occupation-label">
                                                        <i class="fas fa-tools"></i>
                                                        <span>Other</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <small class="text-muted">Select all that apply to your skills</small>
                                            @error('occupation')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="experience" class="form-label required-field">Years of Experience</label>
                                            <select class="form-select @error('experience') is-invalid @enderror" 
                                                    id="experience" 
                                                    name="experience" 
                                                    required>
                                                <option value="">Select years of experience</option>
                                                <option value="0-1" {{ (old('experience', $profile->experience ?? '') == '0-1') ? 'selected' : '' }}>Less than 1 year</option>
                                                <option value="1-3" {{ (old('experience', $profile->experience ?? '') == '1-3') ? 'selected' : '' }}>1-3 years</option>
                                                <option value="3-5" {{ (old('experience', $profile->experience ?? '') == '3-5') ? 'selected' : '' }}>3-5 years</option>
                                                <option value="5-10" {{ (old('experience', $profile->experience ?? '') == '5-10') ? 'selected' : '' }}>5-10 years</option>
                                                <option value="10+" {{ (old('experience', $profile->experience ?? '') == '10+') ? 'selected' : '' }}>More than 10 years</option>
                                            </select>
                                            @error('experience')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="qualification" class="form-label required-field">Highest Qualification</label>
                                            <select class="form-select @error('qualification') is-invalid @enderror" 
                                                    id="qualification" 
                                                    name="qualification" 
                                                    required>
                                                <option value="">Select your qualification</option>
                                                <option value="High School" {{ (old('qualification', $profile->qualification ?? '') == 'High School') ? 'selected' : '' }}>High School</option>
                                                <option value="ITI" {{ (old('qualification', $profile->qualification ?? '') == 'ITI') ? 'selected' : '' }}>ITI</option>
                                                <option value="Diploma" {{ (old('qualification', $profile->qualification ?? '') == 'Diploma') ? 'selected' : '' }}>Diploma</option>
                                                <option value="Bachelor's Degree" {{ (old('qualification', $profile->qualification ?? '') == 'Bachelor\'s Degree') ? 'selected' : '' }}>Bachelor's Degree</option>
                                                <option value="Other" {{ (old('qualification', $profile->qualification ?? '') == 'Other') ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('qualification')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Your Address</h5>
                                    </div>
                                    <div class="form-section">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group mb-4">
                                                    <label for="address" class="form-label required-field">Complete Address</label>
                                                    <div class="address-input-wrapper">
                                                        <input type="text" 
                                                               class="form-control @error('address') is-invalid @enderror" 
                                                               id="address" 
                                                               name="address" 
                                                               value="{{ old('address', $profile->address ?? '') }}" 
                                                               placeholder="Start typing your address..."
                                                               required>
                                                        <i class="fas fa-map-marker-alt location-icon"></i>
                                                    </div>
                                                     <div class="text-center mt-2">OR</div>
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-outline-primary w-100 w-md-auto"
                                                    id="useCurrentLocation">
                                                    <i class="fas fa-location-arrow text-warning"></i> Use Current Location
                                                </button>

                                            </div>
                                                    <p class="help-text mt-2">Type your address and select from the suggestions</p>
                                                    @error('address')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Hidden fields for storing address components -->
                                            <input type="hidden" id="street_number" name="street_number" value="{{ old('street_number', $profile->street_number ?? '') }}">
                                            <input type="hidden" id="route" name="route" value="{{ old('route', $profile->route ?? '') }}">
                                            <input type="hidden" id="locality" name="locality" value="{{ old('locality', $profile->locality ?? '') }}">
                                            <input type="hidden" id="administrative_area_level_1" name="state" value="{{ old('state', $profile->state ?? '') }}">
                                            <input type="hidden" id="postal_code" name="postal_code" value="{{ old('postal_code', $profile->postal_code ?? '') }}">
                                            <input type="hidden" id="country" name="country" value="Pakistan">
                                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $profile->latitude ?? '') }}">
                                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $profile->longitude ?? '') }}">
                                            <input type="hidden" id="area" name="area" value="{{ old('area', $profile->area ?? '') }}">

                                            <!-- Address Preview -->
                                            <div class="col-12">
                                                <div class="address-details" id="address-preview" style="display: none;">
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
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary submit-btn">
                                    <i class="fas fa-save me-2"></i>Save Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
        componentRestrictions: { country: 'pk' }, // Restrict to Pakistan
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
                Swal.fire({
                    icon: 'warning',
                    title: 'Geolocation Not Supported',
                    text: 'Geolocation is not supported by this browser.'
                });
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
                                    document.getElementById('locality').value = component
                                        .long_name;
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Address Error',
                            text: 'Unable to retrieve address. Try again.'
                        });
                    }
                });
            }

            function errorCallback(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Geolocation Error',
                    text: 'Geolocation error: ' + error.message
                });
            }
        });

        // Handle occupation checkbox visual feedback
        document.addEventListener('DOMContentLoaded', function() {
            const occupationCheckboxes = document.querySelectorAll('.occupation-checkbox');
            
            occupationCheckboxes.forEach(checkbox => {
                const option = checkbox.closest('.occupation-option');
                
                // Set initial state
                if (checkbox.checked) {
                    option.classList.add('selected');
                }
                
                // Handle change events
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        option.classList.add('selected');
                    } else {
                        option.classList.remove('selected');
                    }
                });
            });
        });
</script>



@endsection
