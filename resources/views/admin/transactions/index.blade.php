@extends('layouts.app')

@section('title', 'Tabel Transaksi')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-9 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="far fa-user"></i> <!-- icon untuk total transaksi -->
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="font-weight-bolder">Total Transaksi</h4>
                            </div>
                            <div class="card-body">{{ $totalTransactions }}</div> <!-- menampilkan total transaksi -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-9 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-circle-user"></i> <!-- icon untuk user -->
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Transaksi Selesai</h4>
                            </div>
                            <div class="card-body">
                                -- <!-- menampilkan total transaksi selesai -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-9 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-secondary">
                            <i class="fas fa-users"></i> <!-- icon untuk total user -->
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>--</h4>
                            </div>
                            <div class="card-body">
                                {{-- {{ $totalUser }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="card">
            <div class="col-12">
                        @include('layouts.alert')
                    </div>
            <div class="card-header d-flex justify-content-between align-items-center">

                <h4>Daftar Transaksi Sampah</h4>
                <form method="GET" action="{{ route('transactions.index') }}" class="form-inline">
                    <label for="statusFilter" class="mr-2">Filter Status:</label>
                    <select name="status" id="statusFilter" onchange="this.form.submit()"
                        class="form-control d-inline-block w-auto">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="menunggu konfirmasi"
                            {{ request('status') == 'menunggu konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="dijemput" {{ request('status') == 'dijemput' ? 'selected' : '' }}>Dijemput</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User</th> <!-- nama user -->
                        <th>Nama Sampah</th> <!-- nama sampah -->
                        <th>Jumlah</th> <!-- jumlah sampah -->
                        <th>Tanggal Penjemputan</th> <!-- tanggal penjemputan -->
                        <th>Status</th> <!-- status transaksi -->
                        <th>Aksi</th> <!-- aksi yang bisa dilakukan -->
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $trx)
                        <tr>
                            <td>{{ $trx->user->name }}</td> <!-- nama user -->
                            <td>{{ $trx->jenis_sampah}}</td> <!-- nama sampah -->
                            <td>{{ $trx->jumlah }} kg</td> <!-- jumlah sampah -->
                            <td>{{ Carbon\Carbon::parse($trx->tanggal_penjemputan)->format('d M Y') }}</td> <!-- tanggal penjemputan -->
                            <td>
                                <span
                                    class="badge
                                @if ($trx->status == 'menunggu konfirmasi') badge-warning
                                @elseif($trx->status == 'dijemput') badge-info
                                @elseif($trx->status == 'diproses') badge-primary
                                @else badge-success @endif">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td> <!-- status transaksi -->
                            <td>
                                @if ($trx->status === 'menunggu konfirmasi')
                                    <form action="{{ url('/sell/' . $trx->id . '/pickup') }}" method="POST"
                                        style="display:inline;" onsubmit="return showActionMessage('Konfirmasi penjemputan?')">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Konfirmasi</button>
                                    </form> <!-- konfirmasi penjemputan -->
                                @elseif($trx->status === 'dijemput')
                                    <form action="{{ url('/sell/' . $trx->id . '/mark-processed') }}" method="POST"
                                        style="display:inline;" onsubmit="return showActionMessage('Proses transaksi?')">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Proses</button>
                                    </form> <!-- proses transaksi -->
                                @elseif($trx->status === 'diproses')
                                    <form action="{{ url('/sell/' . $trx->id . '/complete') }}" method="POST"
                                        style="display:inline;" onsubmit="return showActionMessage('Selesaikan transaksi?')">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Selesaikan</button>
                                    </form> <!-- selesaikan transaksi -->
                                @else
                                    <small>Selesai</small>
                                @endif
                            </td>
                            <script>
                                function showActionMessage(message) {
                                    return confirm(message);
                                }
                            </script>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection

