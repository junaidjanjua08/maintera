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
        background: linear-gradient(45deg, #4e73df, #224abe);
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
                                            <img src="{{ $technician->profile_image ?? asset('images/default-profile.png') }}" 
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
                                                   value="{{ old('name', $technician->name ?? '') }}" 
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
                                                   value="{{ old('email', $technician->email ?? '') }}" 
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
                                                   value="{{ old('phone', $technician->phone ?? '') }}" 
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
                                            <label for="occupation" class="form-label required-field">What type of technician are you?</label>
                                            <select class="form-select @error('occupation') is-invalid @enderror" 
                                                    id="occupation" 
                                                    name="occupation" 
                                                    required>
                                                <option value="">Select your specialization</option>
                                                <option value="AC Repair" {{ (old('occupation', $technician->occupation ?? '') == 'AC Repair') ? 'selected' : '' }}>AC Repair</option>
                                                <option value="Refrigerator Repair" {{ (old('occupation', $technician->occupation ?? '') == 'Refrigerator Repair') ? 'selected' : '' }}>Refrigerator Repair</option>
                                                <option value="Washing Machine Repair" {{ (old('occupation', $technician->occupation ?? '') == 'Washing Machine Repair') ? 'selected' : '' }}>Washing Machine Repair</option>
                                                <option value="TV Repair" {{ (old('occupation', $technician->occupation ?? '') == 'TV Repair') ? 'selected' : '' }}>TV Repair</option>
                                                <option value="Computer Repair" {{ (old('occupation', $technician->occupation ?? '') == 'Computer Repair') ? 'selected' : '' }}>Computer Repair</option>
                                                <option value="Mobile Phone Repair" {{ (old('occupation', $technician->occupation ?? '') == 'Mobile Phone Repair') ? 'selected' : '' }}>Mobile Phone Repair</option>
                                                <option value="Electrical Work" {{ (old('occupation', $technician->occupation ?? '') == 'Electrical Work') ? 'selected' : '' }}>Electrical Work</option>
                                                <option value="Plumbing" {{ (old('occupation', $technician->occupation ?? '') == 'Plumbing') ? 'selected' : '' }}>Plumbing</option>
                                                <option value="Other" {{ (old('occupation', $technician->occupation ?? '') == 'Other') ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('occupation')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="experience" class="form-label required-field">Years of Experience</label>
                                            <select class="form-select @error('experience') is-invalid @enderror" 
                                                    id="experience" 
                                                    name="experience" 
                                                    required>
                                                <option value="">Select years of experience</option>
                                                <option value="0-1" {{ (old('experience', $technician->experience ?? '') == '0-1') ? 'selected' : '' }}>Less than 1 year</option>
                                                <option value="1-3" {{ (old('experience', $technician->experience ?? '') == '1-3') ? 'selected' : '' }}>1-3 years</option>
                                                <option value="3-5" {{ (old('experience', $technician->experience ?? '') == '3-5') ? 'selected' : '' }}>3-5 years</option>
                                                <option value="5-10" {{ (old('experience', $technician->experience ?? '') == '5-10') ? 'selected' : '' }}>5-10 years</option>
                                                <option value="10+" {{ (old('experience', $technician->experience ?? '') == '10+') ? 'selected' : '' }}>More than 10 years</option>
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
                                                <option value="High School" {{ (old('qualification', $technician->qualification ?? '') == 'High School') ? 'selected' : '' }}>High School</option>
                                                <option value="ITI" {{ (old('qualification', $technician->qualification ?? '') == 'ITI') ? 'selected' : '' }}>ITI</option>
                                                <option value="Diploma" {{ (old('qualification', $technician->qualification ?? '') == 'Diploma') ? 'selected' : '' }}>Diploma</option>
                                                <option value="Bachelor's Degree" {{ (old('qualification', $technician->qualification ?? '') == 'Bachelor\'s Degree') ? 'selected' : '' }}>Bachelor's Degree</option>
                                                <option value="Other" {{ (old('qualification', $technician->qualification ?? '') == 'Other') ? 'selected' : '' }}>Other</option>
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
                                                               value="{{ old('address', $technician->address ?? '') }}" 
                                                               placeholder="Start typing your address..."
                                                               required>
                                                        <i class="fas fa-map-marker-alt location-icon"></i>
                                                    </div>
                                                    <p class="help-text mt-2">Type your address and select from the suggestions</p>
                                                    @error('address')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Hidden fields for storing address components -->
                                            <input type="hidden" id="street_number" name="street_number" value="{{ old('street_number', $technician->street_number ?? '') }}">
                                            <input type="hidden" id="route" name="route" value="{{ old('route', $technician->route ?? '') }}">
                                            <input type="hidden" id="locality" name="locality" value="{{ old('locality', $technician->locality ?? '') }}">
                                            <input type="hidden" id="administrative_area_level_1" name="state" value="{{ old('state', $technician->state ?? '') }}">
                                            <input type="hidden" id="postal_code" name="postal_code" value="{{ old('postal_code', $technician->postal_code ?? '') }}">
                                            <input type="hidden" id="country" name="country" value="Pakistan">
                                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $technician->latitude ?? '') }}">
                                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $technician->longitude ?? '') }}">
                                            <input type="hidden" id="area" name="area" value="{{ old('area', $technician->area ?? '') }}">

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
</script>



@endsection
