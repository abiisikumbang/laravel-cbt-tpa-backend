@extends('layouts.app')

@section('title', 'Profile')

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
                <h1>Profile</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">User Info</div>
                            <div class="card-body">
                                @if (session('success_profile'))
                                    <div class="alert alert-success">{{ session('success_profile') }}</div>
                                @endif
                                <form action="{{ route('profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" name="name" value="{{ Auth::user()->name }}"
                                            class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" value="{{ Auth::user()->email }}"
                                            class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>No HP</label>
                                        <input type="text" name="phone" value="{{ Auth::user()->phone }}"
                                            class="form-control">
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-2">Update Profile</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Ganti Password</div>
                            <div class="card-body">
                                @if (session('success_password'))
                                    <div class="alert alert-success">{{ session('success_password') }}</div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                <form action="{{ route('profile.change-password') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label>Password Saat Ini</label>
                                        <input type="password" name="current_password" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Password Baru</label>
                                        <input type="password" name="new_password" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Konfirmasi Password Baru</label>
                                        <input type="password" name="new_password_confirmation" class="form-control"
                                            required>
                                    </div>

                                    <button type="submit" class="btn btn-warning mt-2">Ganti Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
