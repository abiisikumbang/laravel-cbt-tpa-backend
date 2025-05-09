@extends('layouts.app')

@section('title', 'Users')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content ">
        <section class="section">
            <div class="section-header">
                <h1>Users</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="home">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="user">All Users</a></div>
                    </div>
            </div>
            <div class="section-body">
                <div class="row">
                        <div class="col-12">
                            @include('layouts.alert')
                        </div>
                </div>
                {{-- <h2 class="section-title">Users</h2>
                <p class="section-lead">
                    You can manage all Users, such as editing, deleting and more.
                </p> --}}

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="d-flex align-items-center mb-3 ml-4 mt-3 mr-4">
                                <div>
                                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></a>
                                </div>
                                <div class="ml-auto">
                                    <form method="GET" action="{{ route('users.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name" value="{{ request('name') }}">
                                            <select name="role" class="form-control" onchange="this.form.submit()">
                                                <option value="">All Roles</option>
                                                <option value="ADMIN" {{ request('role') == 'ADMIN' ? 'selected' : '' }}>Admin</option>
                                                <option value="STAFF" {{ request('role') == 'STAFF' ? 'selected' : '' }}>Staff</option>
                                                <option value="USER" {{ request('role') == 'USER' ? 'selected' : '' }}>User</option>
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- <div class="float-left">
                                <select class="form-control selectric">
                                    <option>Action For Selected</option>
                                    <option>Move to Draft</option>
                                    <option>Move to Pending</option>
                                    <option>Delete Pemanently</option>
                                </select>
                            </div> --}}
                            {{-- <div class="d-flex align-items-center">
                                    <div class="card-header d-flex justify-center">
                                        <div class="section-header-button ">
                                            <a href="{{ route('users.create') }}" class="btn btn-primary">Add New</a>
                                        </div>
                                    </div>
                                    <div class="mr-2">
                                        <form method="GET" action="{{ route('users.index') }}">
                                            <div class="input-group">
                                                <input type="text" class="form-control mr-2"         placeholder="Search" name="name">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div>
                                        <form method="GET" action="{{ route('users.index') }}">
                                            <div class="form-inline">
                                                <label for="role" class="mr-2">Filter by Role</label>
                                                <select name="role" id="role" class="form-control mr-2" onchange="this.form.submit()">
                                                    <option value="">All Roles</option>
                                                    <option value="ADMIN" {{ request('role') == 'ADMIN' ? 'selected' : '' }}>Admin</option>
                                                    <option value="CUSTOMER" {{ request('role') == 'CUSTOMER' ? 'selected' : '' }}>Customer</option>
                                                </select>
                                                <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div> --}}
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>

                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Created At</th>
                                            <th>Roles</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->created_at }}</td>
                                                <td>{{ $user->roles}} </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">

                                                        <a href='{{ route('users.edit', $user->id) }}'
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                            class="ml-2">
                                                            <input type="hidden" name="_method" value="DELETE" />
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}" />
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
{{-- //membuat tampilan detail user --}}
                                                            <a href='{{ route('users.show', $user->id) }}' class="btn btn-sm btn-primary btn-icon ml-2">
                                                                <i class="fas fa-eye"></i> Detail</a>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>

                                <div class="float-right">
                                    {{ $users->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

    {{-- modal
    <div class="modal fade" id="userDetailModal" tabindex="-1" role="dialog" aria-labelledby="userDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userDetailModalLabel">User Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="userDetailContent">
                        <p>Sedang memuat detail...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div> --}}

    @push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    @endpush

