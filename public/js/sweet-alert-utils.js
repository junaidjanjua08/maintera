// SweetAlert Utility Functions for Maintera
// Provides consistent styling and behavior across the application

// Success alert with auto-close
function showSuccessAlert(message, title = 'Success!') {
    return Swal.fire({
        icon: 'success',
        title: title,
        text: message,
        timer: 2000,
        showConfirmButton: false,
        confirmButtonColor: '#28a745'
    });
}

// Error alert
function showErrorAlert(message, title = 'Error!') {
    return Swal.fire({
        icon: 'error',
        title: title,
        text: message,
        confirmButtonColor: '#dc3545'
    });
}

// Warning alert
function showWarningAlert(message, title = 'Warning!') {
    return Swal.fire({
        icon: 'warning',
        title: title,
        text: message,
        confirmButtonColor: '#ffc107'
    });
}

// Info alert
function showInfoAlert(message, title = 'Information') {
    return Swal.fire({
        icon: 'info',
        title: title,
        text: message,
        confirmButtonColor: '#17a2b8'
    });
}

// Confirmation dialog
function showConfirmDialog(message, title = 'Confirm Action', confirmText = 'Yes, proceed!', cancelText = 'Cancel') {
    return Swal.fire({
        title: title,
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: confirmText,
        cancelButtonText: cancelText
    });
}

// Delete confirmation dialog
function showDeleteConfirmDialog(message = 'This action cannot be undone.', title = 'Delete Confirmation') {
    return Swal.fire({
        title: title,
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    });
}

// Toast notification
function showToast(message, type = 'success') {
    return Swal.fire({
        icon: type,
        title: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}

// Loading alert
function showLoadingAlert(message = 'Processing...') {
    return Swal.fire({
        title: message,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

// Close loading alert
function closeLoadingAlert() {
    Swal.close();
}

// Success with redirect
function showSuccessAndRedirect(message, redirectUrl, title = 'Success!') {
    return Swal.fire({
        icon: 'success',
        title: title,
        text: message,
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = redirectUrl;
    });
}

// Success with reload
function showSuccessAndReload(message, title = 'Success!') {
    return Swal.fire({
        icon: 'success',
        title: title,
        text: message,
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        location.reload();
    });
}

// Geolocation error handler
function showGeolocationError(error) {
    let message = 'Geolocation error occurred.';
    
    switch(error.code) {
        case error.PERMISSION_DENIED:
            message = 'Geolocation permission denied. Please enable location access.';
            break;
        case error.POSITION_UNAVAILABLE:
            message = 'Location information is unavailable.';
            break;
        case error.TIMEOUT:
            message = 'Geolocation request timed out.';
            break;
        default:
            message = 'Geolocation error: ' + error.message;
    }
    
    return showErrorAlert(message, 'Geolocation Error');
}

// Form validation error
function showValidationError(message) {
    return showWarningAlert(message, 'Validation Error');
}

// Network error handler
function showNetworkError() {
    return showErrorAlert('Network error occurred. Please check your connection and try again.', 'Connection Error');
}

// File upload error
function showFileUploadError(message = 'Failed to upload file. Please try again.') {
    return showErrorAlert(message, 'Upload Error');
}

// Permission denied error
function showPermissionError(message = 'You do not have permission to perform this action.') {
    return showErrorAlert(message, 'Permission Denied');
}

// Not found error
function showNotFoundError(message = 'The requested resource was not found.') {
    return showErrorAlert(message, 'Not Found');
}

// Server error
function showServerError(message = 'An internal server error occurred. Please try again later.') {
    return showErrorAlert(message, 'Server Error');
}

// Export SweetAlert utilities globally
window.SweetAlertUtils = {
    showSuccessAlert,
    showErrorAlert,
    showWarningAlert,
    showInfoAlert,
    showConfirmDialog,
    showDeleteConfirmDialog,
    showToast,
    showLoadingAlert,
    closeLoadingAlert,
    showSuccessAndRedirect,
    showSuccessAndReload,
    showGeolocationError,
    showValidationError,
    showNetworkError,
    showFileUploadError,
    showPermissionError,
    showNotFoundError,
    showServerError
}; 