@extends('layouts.app')

@section('title', 'Tabel Stok Produk')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="row mb-4 mt-4">
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
                                    <!-- Tombol Tambah -->
                                    <button class="btn btn-success mb-3" data-toggle="modal"
                                        data-target="#addRewardModal">
                                        <i class="fas fa-plus"></i> Tambah Produk
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table-striped table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Biaya Poin</th>
                                            <th class="text-center">Stok</th>
                                            <th class="text-center">Gambar</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0 text-center">
                                        @foreach ($stocks as $stock)
                                            <tr>
                                                <td>{{ $stock->id }}</td>
                                                <td>{{ $stock->name }}</td>
                                                <td>{{ $stock->point_cost }}</td>
                                                <td>{{ $stock->stock }}</td>
                                                <td><img src="{{ asset('storage/' . $stock->image) }}" width="60"></td>
                                                <td>
                                                    <!-- Modal Buttons -->

                                                    {{-- detail --}}
                                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target="#detailRewardModal{{ $stock->id }}">Detail</button>

                                                    {{-- edit --}}
                                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#editRewardModal{{ $stock->id }}">
                                                        Edit
                                                    </button>

                                                    {{-- hapus --}}
                                                    <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST"
                                                        class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                @include('admin.stocks.modals.create')
                @include('admin.stocks.modals.detail')
                @include('admin.stocks.modals.edit')
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $('.table').DataTable();
        });
    </script>
@endsection
