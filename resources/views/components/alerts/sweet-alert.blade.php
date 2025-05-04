<!-- sweet-alert.blade.php -->

@if(session('sweet_success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('sweet_success') }}',
            confirmButtonColor: '#3085d6'
        });
    </script>
@endif

@if(session('sweet_error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('sweet_error') }}',
            confirmButtonColor: '#d33'
        });
    </script>
@endif
