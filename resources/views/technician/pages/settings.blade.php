@extends('technician.index')

@section('content')


    <div class="container-fluid px-6 py-4">

        <!-- Email Settings Section -->
        <div class="row mb-8">
            <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                <div class="mb-4 mb-lg-0">
                    <h4 class="section-title">Email Settings</h4>
                    <p class="fs-5 text-muted">Update your email address and profile settings</p>
                </div>
            </div>

            <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                <!-- Card for Email Settings -->
                <div class="card shadow-lg rounded-lg" id="edit">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Update Email Address</h4>
                        <form action="{{ route('technician.updateEmail') }}" method="POST">
                            @csrf
                            <div class="mb-3 row">
                                <label for="newEmailAddress" class="col-sm-4 col-form-label form-label">New Email</label>
                                <div class="col-md-8 col-12">
                                    <input type="email" class="form-control input-field" name="email"  placeholder="Enter your email address" id="newEmailAddress" required>
                                </div>
                            </div>
                            <div class="offset-md-4 col-md-8 col-12 mt-3">
                                <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Password Section -->
        <div class="row mb-8">
            <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                <div class="mb-4 mb-lg-0">
                    <h4 class="section-title">Change Password</h4>
                    <p class="fs-5 text-muted">Keep your account secure by updating your password</p>
                </div>
            </div>

            <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                <!-- Card for Change Password -->
                <div class="card shadow-lg rounded-lg">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Update Password</h4>
                        <form action="{{ route('technician.updatePassword') }}" method="POST">
                            @csrf
                            <div class="mb-3 row">
                                <label for="currentPassword" class="col-sm-4 col-form-label form-label">Current Password</label>
                                <div class="col-md-8 col-12">
                                    <input type="password" class="form-control input-field" name="currentPassword" placeholder="Enter Current Password" id="currentPassword" required>
                                </div>
                            </div>
                        
                            <div class="mb-3 row">
                                <label for="currentNewPassword" class="col-sm-4 col-form-label form-label">New Password</label>
                                <div class="col-md-8 col-12">
                                    <input type="password" name="newpassword" class="form-control input-field" placeholder="Enter New Password" id="currentNewPassword" required>
                                </div>
                            </div>
                        
                            <div class="row align-items-center">
                                <label for="confirmNewpassword" class="col-sm-4 col-form-label form-label">Confirm New Password</label>
                                <div class="col-md-8 col-12 mb-2 mb-lg-0">
                                    <!-- Updated name attribute -->
                                    <input type="password" class="form-control input-field" name="newpassword_confirmation" placeholder="Confirm New Password" id="confirmNewpassword" required>
                                </div>
                        
                                <div class="offset-md-4 col-md-8 col-12 mt-4">
                                    <h6 class="mb-1">Password Requirements:</h6>
                                    <ul class="password-requirements">
                                        <li>Minimum 8 characters long (the longer, the better)</li>
                                        <li>At least one lowercase letter</li>
                                        <li>At least one uppercase letter</li>
                                        <li>At least one number, symbol, or whitespace character</li>
                                    </ul>
                                    <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Account Section -->
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                <div class="mb-4 mb-lg-0">
                    <h4 class="section-title">Delete Account</h4>
                    <p class="fs-5 text-muted">Permanently delete your account and content</p>
                </div>
            </div>
        
            <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                <!-- Card for Delete Account -->
                <div class="card mb-6 shadow-lg rounded-lg">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Danger Zone</h4>
                        <p class="text-danger">Deleting your account will erase all your data, including articles, comments, chat messages, and more.</p>
                        <!-- Delete Account Button to Trigger Modal -->
                        <a href="#" class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Delete Account</a>
                        <p class="small mb-0 mt-3">For any inquiries, feel free to contact us at <a href="mailto:dashui@example.com">dashui@example.com</a>.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal for Account Deletion Confirmation -->
        <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAccountModalLabel">Confirm Account Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">Are you sure you want to delete your account? This action is irreversible and will delete all your data, including articles, comments, chat messages, and more.</p>
                        <p class="small mb-0 mt-3">If you have any concerns, please contact us at <a href="mailto:dashui@example.com">dashui@example.com</a>.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('technician.deleteAccount') }}" method="POST" id="deleteAccountForm">
                            @csrf
                            <button type="submit" class="btn btn-danger">Delete Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<style>
    /* General Styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f7f7f7;
}

/* Section Titles */
.section-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
}

/* Card Styling */
.card {
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    background: #fff;
    padding: 20px;
}

/* Input Fields */
.input-field {
    border-radius: 5px;
    padding: 10px;
    border: 1px solid #ddd;
    font-size: 1rem;
}

/* Button Styling */
.submit-btn {
    background-color: #007bff;
    color: #fff;
    border-radius: 5px;
    padding: 10px 20px;
    transition: background-color 0.3s ease;
}

.submit-btn:hover {
    background-color: #0056b3;
}

/* Danger Zone Button */
.delete-btn {
    background-color: #dc3545;
    color: #fff;
    padding: 12px 20px;
    font-size: 1rem;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.delete-btn:hover {
    background-color: #c82333;
}

/* Password Requirements */
.password-requirements {
    font-size: 0.9rem;
    list-style-type: disc;
    padding-left: 20px;
}

/* Responsive Design for Smaller Screens */
@media (max-width: 768px) {
    .section-title {
        font-size: 1.25rem;
    }

    .col-xl-9, .col-lg-8, .col-md-12 {
        margin-bottom: 20px;
    }
}

</style>