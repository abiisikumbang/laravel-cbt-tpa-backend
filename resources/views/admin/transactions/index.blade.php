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
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id Transaksi</th>
                        <th>Nama User</th> <!-- nama user -->
                        {{-- <th>Nama Sampah</th> <!-- nama sampah --> --}}
                        <th>Jumlah Subpoint</th> <!-- jumlah sampah -->
                        <th>Tanggal Penjemputan</th> <!-- tanggal penjemputan -->
                        <th>Status</th> <!-- status transaksi -->
                        <th>Aksi</th> <!-- aksi yang bisa dilakukan -->
                        <th>Hapus</th> <!-- aksi hapus -->
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $trx)
                        <tr>
                            <td>{{ $trx->id }}</td>
                            <td>{{ $trx->user->name }}</td> <!-- nama user -->

                            <td>{{ $trx->wastes->sum('point_value') }} </td> <!-- jumlah sampah -->

                            <td>{{ Carbon\Carbon::parse($trx->pickup_date)->format('d M Y') }}</td> <!-- tanggal penjemputan -->

                            <td> <!-- status transaksi -->
                                <span
                                    class="badge
                                @if ($trx->status == 'menunggu konfirmasi') badge-warning
                                @elseif($trx->status == 'dijemput') badge-info
                                @elseif($trx->status == 'diproses') badge-primary
                                @else badge-success @endif">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td>
                            <td> <!-- konfirmasi penjemputan -->
                                @if ($trx->status === 'menunggu konfirmasi')
                                    <form action="{{ url('/sell/' . $trx->id . '/pickup') }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return showActionMessage('Konfirmasi penjemputan?')">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Konfirmasi</button>
                                    </form>
                                @elseif($trx->status === 'dijemput')
                                    <!-- proses transaksi -->
                                    <form action="{{ url('/sell/' . $trx->id . '/mark-processed') }}" method="POST"
                                        style="display:inline;" onsubmit="return showActionMessage('Proses transaksi?')">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Proses</button>
                                    </form>
                                @elseif($trx->status === 'diproses')
                                    <!-- selesaikan transaksi -->
                                    <form action="{{ url('/sell/' . $trx->id . '/complete') }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return showActionMessage('Selesaikan transaksi?')">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Selesaikan</button>
                                    </form>
                                @else
                                    <small class="badge badge-success">Selesai</small>
                                @endif
                            </td>
                            <td> <!-- hapus transaksi -->
                                <form action="{{ url('/sell/' . $trx->id) }}" method="POST" style="display:inline;"
                                    onsubmit="return showActionMessage('Hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
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
            <div class="d-flex justify-content-center">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
@endsection
