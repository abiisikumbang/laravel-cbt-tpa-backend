                <!-- Modal Tambah -->
                <div class="modal fade" id="addWasteModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form action="{{ route('wastes.store') }}" method="POST" enctype="multipart/form-data"
                            class="modal-content">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Sampah</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Nama Sampah</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Point</label>
                                    <input type="number" name="point_value" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Satuan</label>
                                    <input type="text" name="satuan" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Gambar</label>
                                    <input type="file" name="image" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary" type="submit"
                                    onclick="this.disabled=true; this.form.submit();">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
