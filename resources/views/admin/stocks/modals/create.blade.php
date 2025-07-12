<div class="modal fade" id="addRewardModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('stocks.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk</h5>
                <button type="button" class="btn-close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label>Nama</label><input name="name" class="form-control" required></div>
                <div class="mb-3"><label>Biaya Poin</label><input type="number" name="point_cost" class="form-control" required></div>
                <div class="mb-3"><label>Stok</label><input type="number" name="stock" class="form-control" required></div>
                <div class="mb-3"><label>Gambar</label><input type="file" name="image" class="form-control" required></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
