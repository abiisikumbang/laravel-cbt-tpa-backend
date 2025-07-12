                                <!-- Modal Detail user -->
                                <div class="modal fade" id="userDetailModal" tabindex="-1"
                                    aria-labelledby="userDetailModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail User</h5>
                                                <button title="Close" type="button" class="btn-close"
                                                    data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Nama</th>
                                                            <td id="modalName"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Email</th>
                                                            <td id="modalEmail"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Telepon</th>
                                                            <td id="modalPhone"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Point</th>
                                                            <td id="modalPoints"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Role</th>
                                                            <td id="modalRole"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- js for detail modal --}}
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            document.querySelectorAll('[data-toggle="modal"][data-target="#userDetailModal"]').forEach(function(
                                                button) {
                                                button.addEventListener('click', function() {
                                                    document.getElementById('modalName').textContent = button.getAttribute(
                                                        'data-name');
                                                    document.getElementById('modalEmail').textContent = button.getAttribute(
                                                        'data-email');
                                                    document.getElementById('modalPhone').textContent = button.getAttribute(
                                                        'data-phone');
                                                    document.getElementById('modalRole').textContent = button.getAttribute(
                                                        'data-role');
                                                    document.getElementById('modalPoints').textContent = button.getAttribute(
                                                        'data-total_points');
                                                });
                                            });
                                        });
                                    </script>
                                </div>
