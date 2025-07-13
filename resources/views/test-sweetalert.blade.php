<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SweetAlert Test Page - Maintera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/sweet-alert-utils.js') }}"></script>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">SweetAlert Test Page</h3>
                        <p class="mb-0">Testing all SweetAlert implementations</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3">Basic Alerts</h5>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-success" onclick="SweetAlertUtils.showSuccessAlert('This is a success message!')">
                                        Success Alert
                                    </button>
                                    <button class="btn btn-danger" onclick="SweetAlertUtils.showErrorAlert('This is an error message!')">
                                        Error Alert
                                    </button>
                                    <button class="btn btn-warning" onclick="SweetAlertUtils.showWarningAlert('This is a warning message!')">
                                        Warning Alert
                                    </button>
                                    <button class="btn btn-info" onclick="SweetAlertUtils.showInfoAlert('This is an info message!')">
                                        Info Alert
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Confirmation Dialogs</h5>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" onclick="testConfirmDialog()">
                                        Confirm Dialog
                                    </button>
                                    <button class="btn btn-danger" onclick="testDeleteConfirm()">
                                        Delete Confirmation
                                    </button>
                                    <button class="btn btn-success" onclick="testSuccessAndReload()">
                                        Success + Reload
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3">Specialized Alerts</h5>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-secondary" onclick="SweetAlertUtils.showGeolocationError({code: 1, message: 'Permission denied'})">
                                        Geolocation Error
                                    </button>
                                    <button class="btn btn-secondary" onclick="SweetAlertUtils.showValidationError('Please fill all required fields')">
                                        Validation Error
                                    </button>
                                    <button class="btn btn-secondary" onclick="SweetAlertUtils.showNetworkError()">
                                        Network Error
                                    </button>
                                    <button class="btn btn-secondary" onclick="SweetAlertUtils.showPermissionError()">
                                        Permission Error
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Toast & Loading</h5>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-success" onclick="SweetAlertUtils.showToast('This is a toast notification!', 'success')">
                                        Success Toast
                                    </button>
                                    <button class="btn btn-outline-danger" onclick="SweetAlertUtils.showToast('This is an error toast!', 'error')">
                                        Error Toast
                                    </button>
                                    <button class="btn btn-outline-warning" onclick="testLoadingAlert()">
                                        Loading Alert
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Session Flash Messages</h5>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-success" onclick="testSessionSuccess()">
                                        Test Session Success
                                    </button>
                                    <button class="btn btn-danger" onclick="testSessionError()">
                                        Test Session Error
                                    </button>
                                    <button class="btn btn-warning" onclick="testSessionWarning()">
                                        Test Session Warning
                                    </button>
                                    <button class="btn btn-info" onclick="testSessionInfo()">
                                        Test Session Info
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert session handler -->
    <x-alerts.sweet-alert />

    <script>
        function testConfirmDialog() {
            SweetAlertUtils.showConfirmDialog('Are you sure you want to proceed with this action?', 'Confirm Action')
                .then((result) => {
                    if (result.isConfirmed) {
                        SweetAlertUtils.showSuccessAlert('Action confirmed!');
                    }
                });
        }

        function testDeleteConfirm() {
            SweetAlertUtils.showDeleteConfirmDialog('Are you sure you want to delete this item?')
                .then((result) => {
                    if (result.isConfirmed) {
                        SweetAlertUtils.showSuccessAlert('Item deleted successfully!');
                    }
                });
        }

        function testSuccessAndReload() {
            SweetAlertUtils.showSuccessAndReload('Operation completed successfully!');
        }

        function testLoadingAlert() {
            SweetAlertUtils.showLoadingAlert('Processing your request...');
            setTimeout(() => {
                SweetAlertUtils.closeLoadingAlert();
                SweetAlertUtils.showSuccessAlert('Processing completed!');
            }, 3000);
        }

        function testSessionSuccess() {
            fetch('/test-session-success', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            }).then(() => location.reload());
        }

        function testSessionError() {
            fetch('/test-session-error', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            }).then(() => location.reload());
        }

        function testSessionWarning() {
            fetch('/test-session-warning', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            }).then(() => location.reload());
        }

        function testSessionInfo() {
            fetch('/test-session-info', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            }).then(() => location.reload());
        }
    </script>
</body>
</html> 