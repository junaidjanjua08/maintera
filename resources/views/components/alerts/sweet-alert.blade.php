<!-- sweet-alert.blade.php -->

@if(session('sweet_success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('sweet_success') }}',
            confirmButtonColor: '#28a745',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@if(session('sweet_error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('sweet_error') }}',
            confirmButtonColor: '#dc3545'
        });
    </script>
@endif

@if(session('sweet_warning'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: '{{ session('sweet_warning') }}',
            confirmButtonColor: '#ffc107'
        });
    </script>
@endif

@if(session('sweet_info'))
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Information',
            text: '{{ session('sweet_info') }}',
            confirmButtonColor: '#17a2b8'
        });
    </script>
@endif
