@extends('technician.index')
@section('content')
<style>
    /* body {
        background: linear-gradient(to right, #eef2f3, #8e9eab);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding: 20px;
    } */

    .form-container {
        max-width: 1200px;
        margin: auto;
        background: #fff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        transition: 0.3s ease;
    }

    h2 {
        font-size: 22px;
        margin-bottom: 20px;
        color: #444;
        position: relative;
    }

    h2::after {
        content: '';
        width: 60px;
        height: 3px;
        background: #3b82f6;
        position: absolute;
        bottom: -8px;
        left: 0;
        border-radius: 5px;
    }

    .form-control {
        /* width: 100%; */
        padding: 10px 15px;
        border: 2px solid #ccc;
        border-radius: 8px;
        outline: none;
        transition: 0.3s ease;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 10px #3b82f6;
    }

    label {
        font-weight: 600;
        margin-bottom: 6px;
        display: inline-block;
        color: #333;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        transition: 0.3s ease;
        cursor: pointer;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
        box-shadow: 0 0 15px #3b82f6;
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
        box-shadow: 0 0 12px #10b981;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
        box-shadow: 0 0 12px #ef4444;
    }

    .shadow-md {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .rounded-xl {
        border-radius: 20px;
    }

    .glow-box {
        animation: glow 2s infinite alternate;
    }

    @keyframes glow {
        from {
            box-shadow: 0 0 10px #3b82f6, 0 0 20px #3b82f6;
        }
        to {
            box-shadow: 0 0 20px #60a5fa, 0 0 30px #60a5fa;
        }
    }

    .text-right {
        text-align: right;
        margin-top: 20px;
    }

    /* Responsive grid (fallback for Tailwind’s grid) */
    .grid {
        display: grid;
        grid-gap: 20px;
    }

    .grid-cols-1 {
        grid-template-columns: 1fr;
    }

    .md\\:grid-cols-2 {
        grid-template-columns: 1fr 1fr;
    }

    @media (max-width: 768px) {
        .md\\:grid-cols-2 {
            grid-template-columns: 1fr;
        }
    }
</style>

            <div class="row">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
    
                    {{-- GROUP: Personal Info + Address Details --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
                        {{-- SECTION: Personal Information --}}
                        <div class="bg-white p-6 rounded-xl shadow-md">
                            <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">1. Personal Information</h2>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block mb-1 font-medium" for="name">Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
    
                                <div>
                                    <label class="block mb-1 font-medium" for="email">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
    
                                <div>
                                    <label class="block mb-1 font-medium" for="cnic">CNIC</label>
                                    <input type="text" name="cnic" class="form-control" required>
                                </div>
    
                                <div>
                                    <label class="block mb-1 font-medium" for="phone">Phone</label>
                                    <input type="text" name="phone" class="form-control" required>
                                </div>
                            </div>
                        </div>
    
                        {{-- SECTION: Profile Picture --}}
                        <div class="bg-white p-6 rounded-xl shadow-md">
                            <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">2. Profile Picture</h2>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block mb-1 font-medium" for="profile_picture">Profile Picture</label>
                                    <input type="file" name="profile_picture" class="form-control">
                                </div>
                            </div>
                        </div>
    
                        {{-- SECTION: Address Details --}}
                        <div class="bg-white p-6 rounded-xl shadow-md">
                            <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">3. Address Details</h2>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block mb-1 font-medium" for="city">City</label>
                                    <select name="city" id="city" class="form-control">
                                        <option value="">Select City</option>
                                        <option value="islamabad">Islamabad</option>
                                        <option value="lahore">Lahore</option>
                                        <option value="karachi">Karachi</option>
                                    </select>
                                </div>
    
                                <div>
                                    <label class="block mb-1 font-medium" for="area">Area</label>
                                    <select name="area" id="area" class="form-control">
                                        <option value="">Select Area</option>
                                    </select>
                                </div>
    
                                <div>
                                    <label class="block mb-1 font-medium" for="street_address">Street Address</label>
                                    <input type="text" name="street_address" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
    
                    {{-- SECTION: Education and Certification --}}
                    <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">4. Education & Certification</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 font-medium" for="qualification">Highest Qualification</label>
                                <select name="qualification" class="form-control">
                                    <option value="">Select Qualification</option>
                                    <option value="matric">Matric</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="bachelor">Bachelor</option>
                                    <option value="master">Master</option>
                                    <option value="phd">PhD</option>
                                </select>
                            </div>
    
                            <div>
                                <label class="block mb-1 font-medium" for="certification">Field Certification</label>
                                <input type="text" name="certification" class="form-control" placeholder="e.g. Electrical diploma">
                            </div>
                        </div>
                    </div>
    
                    {{-- SECTION: Experience --}}
                    <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">5. Experience</h2>
                        <div id="experience-container">
                            <div class="flex items-center gap-2 mb-4">
                                <input type="text" name="organization[]" class="form-control w-full mb-2" placeholder="Organization Name">
                                <input type="text" name="field[]" class="form-control w-full mb-2" placeholder="Field">
                                <select name="start_year[]" class="form-control w-full mb-2">
                                    <option value="">Start Year</option>
                                    @for ($year = 2000; $year <= date('Y'); $year++)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                                <select name="end_year[]" class="form-control w-full mb-2">
                                    <option value="">End Year</option>
                                    @for ($year = 2000; $year <= date('Y'); $year++)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                                <button type="button" onclick="addExperienceField()" class="btn btn-success">Add More</button>
                            </div>
                        </div>
                    </div>
    
                    {{-- SECTION: Document Uploads --}}
                    <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">6. Document Uploads</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 font-medium" for="cnic_copy">CNIC *</label>
                                <input type="file" name="cnic_copy" class="form-control">
                            </div>
    
                            <div>
                                <label class="block mb-1 font-medium" for="certificate_file">Certification Document (if any)</label>
                                <input type="file" name="certificate_file" class="form-control">
                            </div>
    
                            <div>
                                <label class="block mb-1 font-medium" for="license_file">License (if any)</label>
                                <input type="file" name="license_file" class="form-control">
                            </div>
                        </div>
                    </div>
    
                    {{-- Submit Button --}}
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary px-6 py-2 rounded-lg shadow-md">Save Profile</button>
                    </div>
                </form>
            </div>
        

    
    <script>
        function addExperienceField() {
            const container = document.getElementById('experience-container');
            const newField = document.createElement('div');
            newField.classList.add('flex', 'items-center', 'gap-2', 'mb-4');
            newField.innerHTML = `
        <input type="text" name="organization[]" class="form-control w-full mb-2" placeholder="Organization Name">
        <input type="text" name="field[]" class="form-control w-full mb-2" placeholder="Field">
        <select name="start_year[]" class="form-control w-full mb-2">
          <option value="">Start Year</option>
          @for ($year = 2000; $year <= date('Y'); $year++)
            <option value="{{ $year }}">{{ $year }}</option>
          @endfor
        </select>
        <select name="end_year[]" class="form-control w-full mb-2">
          <option value="">End Year</option>
          @for ($year = 2000; $year <= date('Y'); $year++)
            <option value="{{ $year }}">{{ $year }}</option>
          @endfor
        </select>
        <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger">Remove</button>
      `;
            container.appendChild(newField);
        }
    </script>
@endsection
