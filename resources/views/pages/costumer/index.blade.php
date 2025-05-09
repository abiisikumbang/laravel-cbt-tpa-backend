{{-- @extends('layouts.app')

@section('title', 'Pelanggan')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Pelanggan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Pelanggan</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pencarian</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <form method="GET" action="{{ route('pelanggan.index') }}">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Cari pelanggan" name="name" value="{{ request()->query('name') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Pelanggan</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Telepon</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pelanggans as $pelanggan)
                                            <tr>
                                                <td>{{ $pelanggan->name }}</td>
                                                <td>{{ $pelanggan->email }}</td>
                                                <td>{{ $pelanggan->phone }}</td>
                                                <td>
                                                    <a href="{{ route('pelanggan.show', $pelanggan->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data pelanggan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection --}}
