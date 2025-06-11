@if ($message = Session::get('success'))

    <div class="alert alert-success alert-dismissible show fade">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
            {{ $message }}
        </div>
    </div>

    {{-- <script>
        $(function() {
            $('.alert').fadeIn().delay(3000).fadeOut();
        });
    </script> --}}
@endif
