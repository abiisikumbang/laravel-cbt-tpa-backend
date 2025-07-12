@foreach ($wastes as $waste)
    <!-- Modal Edit -->
    <div class="modal fade" id="editWasteModal{{ $waste->id }}" tabindex="-1"
        aria-labelledby="editWasteLabel{{ $waste->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('wastes.update', $waste->id) }}" method="POST" enctype="multipart/form-data"
                class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editWasteLabel{{ $waste->id }}">
                        Edit Sampah</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Sampah</label>
                        <input type="text" name="name" value="{{ $waste->name }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Point</label>
                        <input type="integer" name="point_value" value="{{ $waste->point_value }}" class="form-control"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Satuan</label>
                        <input type="text" name="satuan" value="{{ $waste->satuan }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar (kosongkan jika tidak
                            diubah)</label>
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
