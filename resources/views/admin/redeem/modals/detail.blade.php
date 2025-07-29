<!-- Modal Detail Transaksi Redeem -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Transaksi Redeem</h5>
                <button class="btn-close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-3">ID Redeem</dt>
                    <dd class="col-sm-7 font-weight-bold" id="redeemId"></dd>

                    <dt class="col-sm-3">Nama User</dt>
                    <dd class="col-sm-7 font-weight-bold" id="userName"></dd>

                    <dt class="col-sm-3">Tanggal</dt>
                    <dd class="col-sm-7 font-weight-bold" id="createdAt"></dd>
                </dl>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Total Point</th>
                        </tr>
                    </thead>
                    <tbody id="modalContent">
                        <!-- Akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <form id="deleteForm" method="POST" style="display:inline;"
                    onsubmit="return showActionMessage('Hapus redeem ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
