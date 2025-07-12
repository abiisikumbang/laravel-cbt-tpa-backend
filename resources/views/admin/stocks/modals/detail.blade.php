@foreach ($stocks as $stock)
    <div class="modal fade" id="detailRewardModal{{ $stock->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Produk</h5>
                    <button class="btn-close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table-striped table">
                        <tbody>
                            <tr>
                                <th scope="row">ID</th>
                                <td>{{ $stock->id }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nama</th>
                                <td>{{ $stock->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Biaya Poin</th>
                                <td>{{ $stock->point_cost }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Stok</th>
                                <td>{{ $stock->stock }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Gambar</th>
                                <td>
                                    <img src="{{ asset('storage/' . $stock->image) }}" class="img-fluid mt-2"
                                        style="max-height: 200px;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
