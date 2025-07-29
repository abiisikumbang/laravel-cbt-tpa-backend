@extends('layouts.app')

@section('title', 'Tabel Transaksi Redeem')

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
                <h4>Daftar Transaksi Redeem</h4>
                <form method="GET" action="{{ route('redeem.index') }}" class="form-inline">
                    <label for="statusFilter" class="mr-2">Filter Status:</label>
                    <select name="status" id="statusFilter" onchange="this.form.submit()"
                        class="form-control d-inline-block w-auto">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="menunggu konfirmasi" {{ request('status') == 'menunggu konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="diantar" {{ request('status') == 'diantar' ? 'selected' : '' }}>Diantar</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="w-full text-sm table table-hover">
                <thead>
                    <tr>
                        <th>Id Redeem</th>
                        <th>Nama User</th>
                        <th>Tanggal Redeem</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($redeems as $redeem)
                        <tr onclick="showDetail({{ $redeem->id }})" style="cursor: pointer;">

                            {{-- id redeem --}}
                            <td>{{ $redeem->id }}</td>

                            {{-- nama user --}}
                            <td>{{ $redeem->user->name }}</td>

                            {{-- tanggal redeem --}}
                            <td>{{ \Carbon\Carbon::parse($redeem->created_at)->format('d M Y') }}</td>

                            {{-- status --}}
                            <td>
                                <span
                                    class="badge
                                @switch($redeem->status)
                                    @case('menunggu konfirmasi')
                                        badge-warning
                                        @break

                                    @case('diantar')
                                        badge-info
                                        @break

                                    @case('diproses')
                                        badge-primary
                                        @break

                                    @case('batal')
                                        badge-danger
                                        @break

                                    @default
                                        badge-success
                                @endswitch">
                                    {{ ucfirst($redeem->status) }}
                                </span>
                            </td>
                            {{-- action --}}
                            <td>
                                @if ($redeem->status === 'menunggu konfirmasi')
                                    <form action="{{ url('/redeem/' . $redeem->id . '/delivered') }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return showActionMessage('Konfirmasi pengantaran?')">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Konfirmasi</button>
                                    </form>
                                @elseif($redeem->status === 'diantar')
                                    <!-- proses penukaran -->
                                    <form action="{{ url('/redeem/' . $redeem->id . '/processed') }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return showActionMessage('Proses Redeem?')">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Proses</button>
                                    </form>
                                    <!-- batal penukaran -->
                                    <form action="{{ url('/redeem/' . $redeem->id . '/cancel') }}" method="POST"
                                        style="display:inline;" onsubmit="return showActionMessage('Batal transaksi?')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Batal</button>
                                    </form>
                                @elseif ($redeem->status === 'diproses')
                                    <!-- selesaikan penukaran -->
                                    <form action="{{ url('/redeem/' . $redeem->id . '/complete') }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return showActionMessage('Selesaikan Redeem?')">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Selesaikan</button>
                                    </form>
                                @else
                                    <small>Selesai</small>
                                @endif
                            </td>

                            {{-- hapus redeem --}}
                            <td>
                                <form action="{{ url('/redeem/' . $redeem->id) }}" method="POST" style="display:inline;"
                                    onsubmit="return showActionMessage('Hapus redeem ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt" ></i></button>
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
                            <td colspan="8" class="text-center">Belum ada transaksi redeem</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $redeems->links() }}
            </div>
        </div>
    </div>
    @include('admin.redeem.modals.detail')
@endsection
