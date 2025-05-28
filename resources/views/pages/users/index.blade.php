@extends('layouts.app')

@section('title', 'Users')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('main')
    <div class="main-content ">
        <section class="section">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-9 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="font-weight-bolder">Total Admin</h4>
                            </div>
                            <div class="card-body">{{ $totalAdmin }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-9 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-circle-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Staff</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalStaff }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-9 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-secondary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Users</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUser }}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-3 col-md-6 col-sm-9 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Online Users</h4>
                            </div>
                            <div class="card-body">
                                47
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="d-flex align-items-center mb-3 ml-4 mt-3 mr-4">
                                <div class="section-header-button">
                                    <div class="card-body">

                                        {{-- tombol add user --}}
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#exampleModal"><i class="fas fa-plus"></i>
                                        </button>

                                        {{-- modal add user --}}
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Create New User</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
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

                                                            {{-- name --}}
                                                            <div class="form-group">
                                                                <label>Name</label>
                                                                <input type="text" class="form-control"
                                                                    @error('name') is-invalid @enderror name="name">
                                                                @error('name')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            {{-- email --}}
                                                            <div>
                                                                <label>Email</label>
                                                                <input type="email" class="form-control"
                                                                    @error('email') is-invalid @enderror name="email">
                                                                @error('email')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            {{-- password --}}
                                                            <div class="form-group">
                                                                <label>Password</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fas fa-lock"></i>
                                                                        </div>
                                                                    </div>
                                                                    <input type="password"
                                                                        class="form-control @error('password') is-invalid @enderror"
                                                                        name="password" id="password">
                                                                    <div class="input-group-append">
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            onclick="togglePasswordVisibility('password', this)">
                                                                            <i class="fas fa-eye"></i>
                                                                        </button>
                                                                    </div>
                                                                    @error('password')
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                                {{-- password confirmation --}}
                                                                <div class="form-group">
                                                                    <label>Password Confirmation</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <i class="fas fa-lock"></i>
                                                                            </div>
                                                                        </div>
                                                                        <input type="password" class="form-control"
                                                                            name="password_confirmation"
                                                                            id="password_confirmation">
                                                                        <div class="input-group-append">
                                                                            <button type="button"
                                                                                class="btn btn-outline-secondary"
                                                                                onclick="togglePasswordVisibility('password_confirmation', this)">
                                                                                <i class="fas fa-eye"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- phone --}}
                                                                <div class="form-group">
                                                                    <label class="form-label">Phone</label>
                                                                    <input type="number" class="form-control"
                                                                        name="phone">
                                                                </div>
                                                                {{-- roles --}}
                                                                <div class="form-group">
                                                                    <label class="form-label">Roles</label>
                                                                    <div class="selectgroup w-100">

                                                                        <label class= "selectgroup item">
                                                                            <input type ="radio" name="roles"
                                                                                value="ADMIN" class="selectgroup-input"
                                                                                checked="">
                                                                            <span class="selectgroup-button">Admin</span>
                                                                        </label>

                                                                        <label class="selectgroup item">
                                                                            <input type ="radio" name="roles"
                                                                                value="STAFF" class="selectgroup-input"
                                                                                checked="">
                                                                            <span class="selectgroup-button">Staff</span>
                                                                        </label>

                                                                        <label class="selectgroup item">
                                                                            <input type ="radio" name="roles"
                                                                                value="USER" class="selectgroup-input"
                                                                                checked="">
                                                                            <span class="selectgroup-button">User</span>
                                                                        </label>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- js for password visibility --}}
                                                            <script>
                                                                function togglePasswordVisibility(fieldId, toggleButton) {
                                                                    const passwordField = document.getElementById(fieldId);
                                                                    if (passwordField.type === 'password') {
                                                                        passwordField.type = 'text';
                                                                        toggleButton.querySelector('i').classList.remove('fa-eye');
                                                                        toggleButton.querySelector('i').classList.add('fa-eye-slash');
                                                                    } else {
                                                                        passwordField.type = 'password';
                                                                        toggleButton.querySelector('i').classList.remove('fa-eye-slash');
                                                                        toggleButton.querySelector('i').classList.add('fa-eye');
                                                                    }
                                                                }
                                                            </script>

                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                    class="btn btn-secondary"data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save
                                                                    changes</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"><i
                                            class="fas fa-plus"></i></a> --}}
                                </div>

                                {{-- search bar --}}
                                <div class="ml-auto">
                                    <form method="GET" action="{{ route('users.index') }}">
                                        <div class="input-group mr-2">
                                            <input type="text" class="form-control" placeholder="Search"
                                                name="name" value="{{ request('name') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                            {{-- filter role --}}
                                            <select name="role" class="form-control ml-4 mr-2"
                                                onchange="this.form.submit()">
                                                <option value="">All Roles</option>
                                                <option value="ADMIN" {{ request('role') == 'ADMIN' ? 'selected' : '' }}>
                                                    Admin</option>
                                                <option value="STAFF" {{ request('role') == 'STAFF' ? 'selected' : '' }}>
                                                    Staff</option>
                                                <option value="USER" {{ request('role') == 'USER' ? 'selected' : '' }}>
                                                    User</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table-striped table">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Created At</th>
                                        <th class="text-center">Roles</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ $user->created_at }}</td>
                                            <td>
                                                @if ($user->roles === 'ADMIN')
                                                    <span class="badge bg-success">{{ $user->roles }}</span>
                                                @elseif ($user->roles === 'STAFF')
                                                    <span class="badge bg-info">{{ $user->roles }}</span>
                                                @elseif ($user->roles === 'USER')
                                                    <span class="badge bg-secondary">{{ $user->roles }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center gap-1">
                                                    {{-- EDIT --}}
                                                    @can('update', $user)
                                                        <button class="btn btn-sm btn-info" data-id="{{ $user->id }}"
                                                            onclick='showEditModal(@json($user))'>
                                                            <i class="fas fa-edit"></i>Edit
                                                        </button>
                                                    @endcan

                                                    {{-- DELETE --}}
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                        class="ml-2">
                                                        <input type="hidden" name="_method" value="DELETE" />
                                                        <input type="hidden" name="_token"
                                                            value="{{ csrf_token() }}" />
                                                        @can('delete', $user)
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete"
                                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        @endcan
                                                    </form>
                                                    {{-- DETAIL --}}
                                                    <button href='{{ route('users.show', $user->id) }}'
                                                        class="btn btn-sm btn-primary btn-icon ml-2" data-toggle="modal"
                                                        data-target="#userDetailModal" data-name="{{ $user->name }}"
                                                        data-email="{{ $user->email }}"
                                                        data-phone="{{ $user->phone }}"
                                                        data-role="{{ $user->roles }}">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>

                                <!-- Edit User Modal -->
                                <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editUserModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <form action="{{ route('users.update', $user) }}" id="editUserForm"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            {{-- header edit modal --}}
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit User</h5>
                                                    <button type="button" class="btn-close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <input type="hidden" id="editUserId">
                                                    {{-- name --}}
                                                    <div class="form-group">
                                                        <label for="editName">Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ $user->name }}" id="editName" required>
                                                    </div>
                                                    {{-- email --}}
                                                    <div class="form-group">
                                                        <label for="editEmail">Email</label>
                                                        <input type="email" class="form-control" name="email"
                                                            value="{{ $user->name }}" id="editEmail" required>
                                                    </div>
                                                    {{-- phone --}}
                                                    <div class="form-group">
                                                        <label for="editPhone">Phone</label>
                                                        <input type="numeric" class="form-control" name="phone"
                                                            value="{{ $user->name }}" id="editPhone" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Roles</label>
                                                        <div class="selectgroup w-100" id="editRolesGroup">
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="roles" value="ADMIN"
                                                                    class="selectgroup-input" id="editRoleAdmin">
                                                                {{-- @if ($user->roles == 'ADMIN') checked @endif> --}} <span
                                                                    class="selectgroup-button">Admin</span>
                                                            </label>

                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="roles" value="STAFF"
                                                                    class="selectgroup-input" id="editRoleStaff">
                                                                {{-- @if ($user->roles == 'STAFF') checked @endif> --}}
                                                                <span class="selectgroup-button">Staff</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="roles" value="USER"
                                                                    class="selectgroup-input" id="editRoleUser">
                                                                {{-- @if ($user->roles == 'USER') checked @endif> --}}
                                                                <span class="selectgroup-button">User</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-warning "
                                                        onclick="console.log('Clicked!')">Update</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Modal Detail user -->
                                <div class="modal fade" id="userDetailModal" tabindex="-1"
                                    aria-labelledby="userDetailModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="userDetailModal">
                                                    Detail User
                                                </h5>
                                                <button title="View user detail" type="button" class="btn-close"
                                                    data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Nama:</strong> <span id="modalName"></span></p>
                                                <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                                                <p><strong>Telepon:</strong> <span id="modalPhone"></span></p>
                                                <p><strong>Role:</strong> <span id="modalRole"></span></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="float-right">
                            {{ $users->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection



@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    {{-- js for detail modal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-toggle="modal"][data-target="#userDetailModal"]').forEach(function(
                button) {
                button.addEventListener('click', function() {
                    document.getElementById('modalName').textContent = button.getAttribute(
                        'data-name');
                    document.getElementById('modalEmail').textContent = button.getAttribute(
                        'data-email');
                    document.getElementById('modalPhone').textContent = button.getAttribute(
                        'data-phone');
                    document.getElementById('modalRole').textContent = button.getAttribute(
                        'data-role');
                });
            });
        });
    </script>

    {{-- js for edit modal --}}
    <script>
        function showEditModal(user) {
            document.getElementById('editUserForm').action = `/users/${user.id}`;
            document.getElementById('editName').value = user.name;
            document.getElementById('editEmail').value = user.email;
            document.getElementById('editPhone').value = user.phone;

            // Radio button for roles
            document.getElementById('editRoleAdmin').checked = user.roles === 'ADMIN';
            document.getElementById('editRoleStaff').checked = user.roles === 'STAFF';
            document.getElementById('editRoleUser').checked = user.roles === 'USER';

            $('#editUserModal').modal('show');

            document.getElementById('editUserForm').action =
                `/users/${user.id}`;
            $('#editUserModal').modal('show');
        }
    </script>



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
    {{-- <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script> --}}
@endpush
