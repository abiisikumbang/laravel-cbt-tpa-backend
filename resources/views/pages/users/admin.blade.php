{{-- @extends('layouts.app')

@section('title', 'Admin Users')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Admin Users</h1>
            </div>
            <div class="section-body">
                <div class="table-responsive">
                    <table class="table-striped table">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($users as $user)
                            @if ($user->roles == 'ADMIN')
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <a href='{{ route('users.show', $user->id) }}' class="btn btn-sm btn-primary btn-icon">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href='{{ route('users.edit', $user->id) }}' class="btn btn-sm btn-info btn-icon">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger btn-icon" onclick="return confirm('Are you sure you want to delete this user?')">
                                                <i class="fas fa-times"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
 --}}
