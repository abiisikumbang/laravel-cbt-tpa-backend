@extends('layouts.auth')

@section('title', 'Register')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Register</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input id="name" type="text"
                        class="form-control @error('name')
                        is-invalid
                    @enderror"
                        name="name" autofocus placeholder="Masukkan nama Anda">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- email --}}
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email"
                        class="form-control @error('email')
                        is-invalid
                    @enderror"
                        name="email" autofocus placeholder="Masukkan email Anda">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- phone --}}
                <div class="form-group">
                    <label for="phone">No.Telepon</label>
                    <input id="phone" type="text"
                        class="form-control @error('phone')
                        is-invalid
                    @enderror"
                        name="phone" autofocus placeholder="Masukkan nomor telepon Anda">
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- password --}}
                <div class="form-group">
                    <label for="password" class="d-block">Password</label>
                    <div class="input-group">
                        <input id="password" type="password"
                            class="form-control pwstrength @error('password')
                            is-invalid

                        @enderror"
                            data-indicator="pwindicator" name="password" autofocus placeholder="Masukkan password Anda">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary"
                                onclick="togglePasswordVisibility('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                    </div>
                </div>

                {{-- password confirmation --}}
                <div class="form-group ">
                    <label for="password2" class="d-block">Konfirmasi Password</label>
                    <div class="input-group">
                        <input id="password2" type="password"
                            class="form-control @error('password_confirmation')
                            is-invalid
                        @enderror"
                            name="password_confirmation" autofocus placeholder="Konfirmasi password Anda">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary"
                                onclick="togglePasswordVisibility('password2')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                {{-- toggle password visibility --}}
                <script>
                    /**
                     * Toggle password visibility
                     * @param {string} id - id of the input field
                     */
                    function togglePasswordVisibility(id) {
                        var passwordField = document.getElementById(id);
                        var passwordFieldType = passwordField.getAttribute('type');
                        passwordField.setAttribute('type', passwordFieldType === 'password' ? 'text' : 'password');
                        event.target.innerText = passwordFieldType === 'password' ? 'Hide' : 'Show';
                    }
                </script>




                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/auth-register.js') }}"></script>
@endpush
