@if ($message = Session::get('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ $message }}',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                toast: false,
                position: 'center',
                width: 300,
                customClass: {
                    popup: 'swal2-small'
                }
            });
        });
    </script>
@endif

@if ($message = Session::get('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ $message }}',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                toast: false,
                position: 'center',
                width: 300,
                customClass: {
                    popup: 'swal2-small'
                }
            });
        });
    </script>
@endif
