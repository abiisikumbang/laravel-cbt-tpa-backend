@extends('layouts.app')

@section('title', 'Tabel Sampah')

@section('main')
    <div class="main-content ">
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
                                        data-target="#addWasteModal">
                                        <i class="fas fa-plus"></i> Tambah Sampah
                                    </button>
                                </div>
                            </div>

                            <!-- Tabel -->
                            <div class="table-responsive">
                                <table class="table-striped table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Nama Sampah</th>
                                            <th class="text-center">Point</th>
                                            <th class="text-center">Satuan</th>
                                            <th class="text-center">Gambar</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0 text-center">
                                        @foreach ($wastes as $waste)
                                            <tr>
                                                <td>{{ $waste->id }}</td>
                                                <td>{{ $waste->name }}</td>
                                                <td>{{ $waste->point_value }}</td>
                                                <td>{{ $waste->satuan }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $waste->image) }}"
                                                        alt="{{ $waste->name }}" width="60">
                                                </td>
                                                <td>
                                                    <!-- Modal Buttons -->

                                                    {{-- detail --}}
                                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target="#detailWasteModal{{ $waste->id }}">Detail</button>

                                                    {{-- edit --}}
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#editWasteModal{{ $waste->id }}">
                                                        Edit
                                                    </button>

                                                    {{-- delete --}}
                                                    <form action="{{ route('wastes.destroy', $waste->id) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                        @csrf
                                                        @method('DELETE')
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
                @include('admin.wastes.modals.create')
                @include('admin.wastes.modals.detail')
                @include('admin.wastes.modals.edit')
            </div>

            <script>
                // Fungsi untuk membuat tabel menjadi DataTable
                $(document).ready(function() {
                    $('.table').DataTable();
                });
            </script>
    </div>
@endsection
