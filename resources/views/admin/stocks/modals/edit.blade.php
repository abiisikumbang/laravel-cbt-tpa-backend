@foreach ($stocks as $stock)
    <div class="modal fade" id="editRewardModal{{ $stock->id }}" tabindex="-1"
        aria-labelledby="editRewardLabel{{ $stock->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('stocks.update', $stock->id) }}" method="POST" enctype="multipart/form-data"
                class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editRewardLabel{{ $stock->id }}">Edit Produk</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="name" value="{{ $stock->name }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Biaya Poin</label>
                        <input type="integer" name="point_cost" value="{{ $stock->point_cost }}" class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stock" value="{{ $stock->stock }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar (kosongkan jika tidak ingin diubah)</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endforeach
