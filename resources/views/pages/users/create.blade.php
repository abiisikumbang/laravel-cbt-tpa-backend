@extends('layouts.app')

@section('title', 'Advanced Forms')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Advanced Forms</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="home">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Forms</a></div>
                    <div class="breadcrumb-item">Form Register</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title"> Form Register </h2>
                <p class="section-lead">We provide advanced input fields, such as date picker, color picker, and so on.</p>
                <div class="card">
                    <form action="{{ route('users.store') }}" method="POST">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @csrf
                        <div class="card-header">
                            <h4>Input Text</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" @error('name') is-invalid @enderror
                                    name="name"> @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <label>Email</label>
                                <input type="email" class="form-control" @error('email') is-invalid @enderror
                                    name="email"> @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary toggle-password"
                                            onclick="togglePassword('password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- membuat password confirmation --}}
                                <div class="form-group">
                                    <label>Password Confirmation</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </div>
                                        </div>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="password_confirmation">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary toggle-password"
                                                onclick="togglePassword('password_confirmation')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function togglePassword(fieldId) {
                                    const passwordField = document.getElementById(fieldId);
                                    const toggleButton = passwordField.nextElementSibling.querySelector('i');
                                    if (passwordField.type === 'password') {
                                        passwordField.type = 'text';
                                        toggleButton.classList.remove('fa-eye');
                                        toggleButton.classList.add('fa-eye-slash');
                                    } else {
                                        passwordField.type = 'password';
                                        toggleButton.classList.remove('fa-eye-slash');
                                        toggleButton.classList.add('fa-eye');
                                    }
                                }
                            </script>
                            <div class="form-group">
                                <label>Phone</label>
                                <div class="input-group">
                                    <input type="numeric" class="form-control" name="phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Roles</label>
                                <div class="selectgroup w-100">

                                    <label class= "selectgroup item">
                                        <input type ="radio" name="roles" value="ADMIN" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Admin</span>
                                    </label>

                                    <label class="selectgroup item">
                                        <input type ="radio" name="roles" value="STAFF" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Staff</span>
                                    </label>

                                    <label class="selectgroup item">
                                        <input type ="radio" name="roles" value="USER" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">User</span>
                                    </label>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush
