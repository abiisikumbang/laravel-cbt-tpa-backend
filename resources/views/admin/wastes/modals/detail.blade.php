@foreach ($wastes as $waste)
    <div class="modal fade" id="detailWasteModal{{ $waste->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Sampah</h5>
                    <button class="btn-close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table-striped table">
                        <tbody>
                            <tr>
                                <th scope="row">ID</th>
                                <td>{{ $waste->id }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nama</th>
                                <td>{{ $waste->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Point</th>
                                <td>{{ $waste->point_value }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Satuan</th>
                                <td>{{ $waste->satuan }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Gambar</th>
                                <td><img src="{{ asset('storage/' . $waste->image) }}" class="img-fluid mt-2"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
