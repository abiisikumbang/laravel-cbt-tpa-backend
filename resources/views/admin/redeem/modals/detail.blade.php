<!-- Modal Detail Transaksi Redeem -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Transaksi Redeem</h5>
                <button class="btn-close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Total Point</th>
                        </tr>
                    </thead>
                    <tbody id="modalContent">
                        <!-- Konten akan diisi JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    function showDetail(id) {
        fetch(`/redeem-detail/${id}`)
            .then(res => res.json())
            .then(data => {
                console.log(data); // Untuk debug isi respon

                const content = document.getElementById('modalContent');
                content.innerHTML = `
    <tr>
        <td>${data.items[0]?.name || '-'}</td>
        <td>${data.items[0]?.quantity || '-'}</td>
        <td>${data.total_points_spent}</td>
    </tr>
`;

                // Show modal (Bootstrap 4 pakai jQuery)
                $('#detailModal').modal('show');
            })
            .catch(err => console.error('Error loading detail:', err));
    }
</script>

