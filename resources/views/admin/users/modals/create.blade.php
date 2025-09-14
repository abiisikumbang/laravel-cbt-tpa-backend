                                        {{-- modal add user --}}
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Create New User
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <form action="{{ route('users.store') }}" method="POST">
                                                            @if ($errors->any())
                                                                <div class="alert alert-danger">
                                                                    <ul>
                                                                        @foreach ($errors->all() as $error)
                                                                            <li>{{ $error }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                            @csrf

                                                            {{-- name --}}
                                                            <div class="form-group">
                                                                <label>Name</label>
                                                                <input type="text" class="form-control"
                                                                    @error('name') is-invalid @enderror name="name">
                                                                @error('name')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            {{-- email --}}
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="email" class="form-control"
                                                                    @error('email') is-invalid @enderror name="email">
                                                                @error('email')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            {{-- phone --}}
                                                            <div class="form-group">
                                                                <label class="form-label">Phone</label>
                                                                <input type="int" class="form-control"
                                                                    name="phone">
                                                            </div>
                                                            {{-- password --}}
                                                            <div class="form-group">
                                                                <label>Password</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fas fa-lock"></i>
                                                                        </div>
                                                                    </div>
                                                                    <input type="password"
                                                                        class="form-control @error('password') is-invalid @enderror"
                                                                        name="password" id="password">
                                                                    <div class="input-group-append">
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            onclick="togglePasswordVisibility('password', this)">
                                                                            <i class="fas fa-eye"></i>
                                                                        </button>
                                                                    </div>
                                                                    @error('password')
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            {{-- password confirmation --}}
                                                            <div class="form-group">
                                                                <label>Password Confirmation</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <i class="fas fa-lock"></i>
                                                                        </div>
                                                                    </div>
                                                                    <input type="password" class="form-control"
                                                                        name="password_confirmation"
                                                                        id="password_confirmation">
                                                                    <div class="input-group-append">
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary"
                                                                            onclick="togglePasswordVisibility('password_confirmation', this)">
                                                                            <i class="fas fa-eye"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- roles --}}
                                                            <div class="form-group">
                                                                <label class="form-label">Roles</label>
                                                                <div class="selectgroup w-100">

                                                                    <label class= "selectgroup item">
                                                                        <input type ="radio" name="roles"
                                                                            value="ADMIN" class="selectgroup-input"
                                                                            checked="">
                                                                        <span class="selectgroup-button">Admin</span>
                                                                    </label>
                                                                    <label class="selectgroup item">
                                                                        <input type ="radio" name="roles"
                                                                            value="USER" class="selectgroup-input"
                                                                            checked="">
                                                                        <span class="selectgroup-button">User</span>
                                                                    </label>

                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    {{-- js for password visibility --}}
                                                    <script>
                                                        function togglePasswordVisibility(fieldId, toggleButton) {
                                                            const passwordField = document.getElementById(fieldId);
                                                            if (passwordField.type === 'password') {
                                                                passwordField.type = 'text';
                                                                toggleButton.querySelector('i').classList.remove('fa-eye');
                                                                toggleButton.querySelector('i').classList.add('fa-eye-slash');
                                                            } else {
                                                                passwordField.type = 'password';
                                                                toggleButton.querySelector('i').classList.remove('fa-eye-slash');
                                                                toggleButton.querySelector('i').classList.add('fa-eye');
                                                            }
                                                        }
                                                    </script>

                                                    <div class="modal-footer">
                                                        <button type="button"
                                                            class="btn btn-secondary"data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            changes</button>
                                                    </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
