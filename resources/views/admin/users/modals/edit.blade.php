                                <!-- Edit User Modal -->
                                <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editUserModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('users.update', $user) }}" id="editUserForm"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            {{-- header edit modal --}}
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit User</h5>
                                                    <button type="button" class="btn-close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <input type="hidden" id="editUserId">

                                                    <div class="form-group">
                                                        <label class="form-label">Roles</label>
                                                        <div class="selectgroup w-100" id="editRolesGroup">
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="roles" value="ADMIN"
                                                                    class="selectgroup-input" id="editRoleAdmin">
                                                                <span class="selectgroup-button">Admin</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="roles" value="USER"
                                                                    class="selectgroup-input" id="editRoleUser">
                                                                <span class="selectgroup-button">User</span>
                                                            </label>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-warning "
                                                        onclick="console.log('Clicked!')">Update</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- js for edit modal --}}
                                    <script>
                                        function showEditModal(user) {
                                            document.getElementById('editUserForm').action = `/users/${user.id}`;
                                            // Radio button for roles
                                            document.getElementById('editRoleAdmin').checked = user.roles === 'ADMIN';
                                            document.getElementById('editRoleUser').checked = user.roles === 'USER';
                                            $('#editUserModal').modal('show');
                                            document.getElementById('editUserForm').action =
                                                `/users/${user.id}`;
                                            $('#editUserModal').modal('show');
                                        }
                                    </script>
                                </div>
