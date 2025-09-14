@extends('layouts.app')

@section('title', 'Users')

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
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#exampleModal">
                                            <i class="fas fa-plus"></i> Tambah User
                                        </button>
                                    </div>
                                </div>

                                {{-- search bar --}}
                                <div class="ml-auto">
                                    <form method="GET" action="{{ route('users.index') }}">
                                        <div class="input-group mr-2">
                                            <input type="text" class="form-control" placeholder="Pencarian" name="name"
                                                value="{{ request('name') }}">
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
                                        <th class="text-center">Roles</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    @foreach ($users as $user)
                                        <tr class="">
                                            <td class="text-center">
                                                {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                            </td>
                                            <td class="text-center">{{ $user->name }}</td>
                                            <td class="text-center">
                                                @if ($user->roles === 'ADMIN')
                                                    <span class="badge bg-success">{{ $user->roles }}</span>
                                                @elseif ($user->roles === 'USER')
                                                    <span class="badge bg-secondary">{{ $user->roles }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{-- action --}}
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
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
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
                                                        data-email="{{ $user->email }}" data-phone="{{ $user->phone }}"
                                                        data-role="{{ $user->roles }}" data-id="{{ $user->id }}"
                                                        data-total_points="{{ $user->total_points }}">

                                                        <i class="fas fa-eye"></i> Detail
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="float-right">
                            {{ $users->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
                @include('admin.users.modals.create')
                @include('admin.users.modals.edit')
                @include('admin.users.modals.detail')
            </div>
        </section>
    </div>
@endsection
