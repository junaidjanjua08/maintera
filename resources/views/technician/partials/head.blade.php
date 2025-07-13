<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">




<!-- Favicon icon-->
<link rel="shortcut icon" type="image/x-icon" href="@@webRoot/assets/images/favicon/favicon.ico">

<!-- Libs CSS -->

<link rel="stylesheet" href="@@webRoot/node_modules/prismjs/themes/prism.css">
<link rel="stylesheet" href="@@webRoot/node_modules/prismjs/plugins/line-numbers/prism-line-numbers.css">
<link rel="stylesheet" href="@@webRoot/node_modules/prismjs/plugins/toolbar/prism-toolbar.css">
<link rel="stylesheet" href="@@webRoot/node_modules/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="@@webRoot/node_modules/dropzone/dist/dropzone.css" >
<link href="@@webRoot/node_modules/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.0/normalize.css">

<!-- Theme CSS -->
<!-- build:css @@webRoot/assets/css/theme.min.css -->
<link rel="stylesheet" href="{{ asset('css/theme.css') }}">
<!-- endbuild -->

{{-- bootstrap cdn --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

{{-- Font Awesome for icons --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* Notification System Styles */
.notification-badge {
    animation: pulse 2s infinite;
    box-shadow: 0 0 0 rgba(220, 53, 69, 0.4);
}

/* Ensure notification icon is visible */
.btn-icon .fas.fa-bell {
    font-size: 1rem;
    color: #6c757d;
    display: inline-block !important;
}

.btn-icon:hover .fas.fa-bell {
    color: #34495e;
}

/* Ensure notification button is visible */
.btn-icon.rounded-circle {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border: 1px solid #dee2e6;
    background-color: #fff;
    transition: all 0.3s ease;
}

.btn-icon.rounded-circle:hover {
    background-color: #f8f9fa;
    border-color: #adb5bd;
}

/* Force notification icon visibility */
#dropdownNotification .fas.fa-bell {
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
    font-size: 1rem !important;
    color: #6c757d !important;
}

#dropdownNotification:hover .fas.fa-bell {
    color: #34495e !important;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
    }
}

.notification-item {
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
}

.notification-item:hover {
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%) !important;
    transform: translateX(5px);
    border-left-color: #34495e;
}

.unread-notification {
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%) !important;
    border-left-color: #34495e !important;
    position: relative;
}

.unread-notification::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
}

.notification-list-scroll::-webkit-scrollbar {
    width: 6px;
}

.notification-list-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.notification-list-scroll::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.notification-list-scroll::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Professional color scheme */
.bg-gradient-primary {
    background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%) !important;
}

.text-primary {
    color: #34495e !important;
}

.text-success {
    color: #27ae60 !important;
}

.text-danger {
    color: #e74c3c !important;
}

.text-info {
    color: #3498db !important;
}

.btn-outline-primary {
    border-color: #34495e !important;
    color: #34495e !important;
}

.btn-outline-primary:hover {
    background-color: #34495e !important;
    border-color: #34495e !important;
    color: white !important;
}

.btn-outline-danger {
    border-color: #e74c3c !important;
    color: #e74c3c !important;
}

.btn-outline-danger:hover {
    background-color: #e74c3c !important;
    border-color: #e74c3c !important;
    color: white !important;
}

/* Dropdown animations */
.dropdown-menu {
    animation: slideInDown 0.3s ease-out;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Loading states */
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}

/* Notification link styles */
.notification-link {
    color: inherit;
    transition: all 0.3s ease;
    position: relative;
}

.notification-link:hover {
    color: #34495e !important;
    text-decoration: none;
}

.notification-link:hover h6 {
    color: #34495e !important;
}

.notification-item:hover .notification-link {
    transform: translateX(3px);
}

.notification-item:hover .notification-link::after {
    content: '\f061';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    color: #34495e;
    font-size: 0.8rem;
    opacity: 0.7;
}

.notification-item {
    cursor: pointer;
}

.notification-item:hover {
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%) !important;
    transform: translateX(5px);
    border-left-color: #34495e;
    box-shadow: 0 2px 8px rgba(52, 73, 94, 0.1);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .dropdown-menu {
        min-width: 300px !important;
    }
    
    .notification-item h6 {
        font-size: 0.85rem !important;
    }
    
    .notification-item p {
        font-size: 0.75rem !important;
    }
}
</style>