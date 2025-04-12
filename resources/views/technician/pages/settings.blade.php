<!DOCTYPE html>
<html lang="en">

<head>
    @include('technician.partials.head')
    <title>Setting | Dash Ui - Bootstrap 5 Admin Dashboard Template</title>
</head>

<body>
    <div id="db-wrapper">
        <!-- navbar vertical -->
        @include('technician/partials/navbar-vertical')
        <!-- Page content -->
        <div id="page-content">
            @include('technician/partials/header')
            <!-- Container fluid -->
            <div class="container-fluid px-6 py-4">


                <div class="row mb-8">
                    <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                        <div class="mb-4 mb-lg-0">
                            <h4 class="mb-1">Email Setting</h4>
                            <p class="mb-0 fs-5 text-muted">Add an email settings to profile </p>
                        </div>

                    </div>

                    <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                        <!-- card -->
                        <div class="card" id="edit">
                            <!-- card body -->
                            <div class="card-body">
                                <div class="mb-6">
                                    <h4 class="mb-1">Email</h4>

                                </div>
                                <form>
                                    <!-- row -->
                                    <div class="mb-3 row">
                                        <!-- label -->
                                        <label for="newEmailAddress"
                                            class="col-sm-4
                        col-form-label form-label">New
                                            email</label>
                                        <div class="col-md-8 col-12">
                                            <!-- input -->
                                            <input type="email" class="form-control"
                                                placeholder="Enter your email address" id="newEmailAddress" required>
                                        </div>
                                        <!-- button -->
                                        <div class="offset-md-4 col-md-8 col-12 mt-3">
                                            <button type="submit" class="btn btn-primary">Save
                                                Changes</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="mb-6 mt-6">
                                    <h4 class="mb-1">Change your password</h4>

                                </div>
                                <form>
                                    <!-- row -->
                                    <div class="mb-3 row">
                                        <label for="currentPassword"
                                            class="col-sm-4
                        col-form-label form-label">Current
                                            password</label>

                                        <div class="col-md-8 col-12">
                                            <input type="password" class="form-control"
                                                placeholder="Enter Current password" id="currentPassword" required>
                                        </div>
                                    </div>
                                    <!-- row -->
                                    <div class="mb-3 row">
                                        <label for="currentNewPassword"
                                            class="col-sm-4
                        col-form-label form-label">New
                                            password</label>

                                        <div class="col-md-8 col-12">
                                            <input type="password" class="form-control" placeholder="Enter New password"
                                                id="currentNewPassword" required>
                                        </div>
                                    </div>
                                    <!-- row -->
                                    <div class="row align-items-center">
                                        <label for="confirmNewpassword"
                                            class="col-sm-4
                        col-form-label form-label">Confirm
                                            new password</label>
                                        <div class="col-md-8 col-12 mb-2 mb-lg-0">
                                            <input type="password" class="form-control"
                                                placeholder="Confirm new password" id="confirmNewpassword" required>
                                        </div>
                                        <!-- list -->
                                        <div class="offset-md-4 col-md-8 col-12 mt-4">
                                            <h6 class="mb-1">Password requirements:</h6>
                                            <p>Ensure that these requirements are met:</p>
                                            <ul>
                                                <li> Minimum 8 characters long the more, the better</li>
                                                <li>At least one lowercase character</li>
                                                <li>At least one uppercase character</li>
                                                <li>At least one number, symbol, or whitespace character
                                                </li>
                                            </ul>
                                            <button type="submit" class="btn btn-primary">Save
                                                Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


              
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                        <div class="mb-4 mb-lg-0">
                            <h4 class="mb-1">Delete Account</h4>
                            <p class="mb-0 fs-5 text-muted">Easily set up social media accounts</p>
                        </div>

                    </div>

                    <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                        <!-- card -->

                        <div class="card mb-6">
                            <!-- card body -->
                            <div class="card-body">
                                <div class="mb-6">
                                    <h4 class="mb-1">Danger Zone </h4>

                                </div>
                                <div>
                                    <!-- text -->
                                    <p>Delete any and all content you have, such as articles, comments, your reading
                                        list or chat messages. Allow your username to become available to anyone.</p>
                                    <a href="#" class="btn btn-danger">Delete Account</a>
                                    <p class="small mb-0 mt-3">Feel free to contact with any <a
                                            href="#">dashui@example.com</a> questions.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    @include('technician.partials.scripts')



</body>

</html>
