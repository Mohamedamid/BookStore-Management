@extends('layouts.apps')

@section('content')
    <div class="container">
        <!-- Users Management Section -->
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0">{{ __('Users Management') }}</h4>
                    </div>

                    <div class="card-body p-4">
                        <div class="mb-4 d-flex justify-content-between">
                            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#addUserModal">
                                <i class="fas fa-user-plus me-2"></i> Add New User
                            </button>

                            <div class="input-group w-50">
                                <input type="text" class="form-control" placeholder="Search users..." id="userSearchInput">
                                <button class="btn btn-outline-secondary" type="button"><i
                                        class="fas fa-search"></i></button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="usersTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar bg-primary rounded-circle me-3 text-white fw-bold d-flex align-items-center justify-content-center"
                                                        style="width:40px;height:40px;">
                                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                                    </div>
                                                    <span>{{ $user->name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @foreach ($user->roles as $role)
                                                    <span class="badge bg-info rounded-pill text-dark">{{ $role->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal" data-id="{{ $user->id }}"
                                                        data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                                        data-roles="{{ implode(',', $user->roles->pluck('id')->toArray()) }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDelete({{ $user->id }})">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>

                                                    <form id="delete-form-{{ $user->id }}" action="{{ route('userDestroy', $user->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add User Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('userStore') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                            <div class="mb-3">
                                <label for="roles" class="form-label">Assign Roles</label>
                                <select name="roles[]" class="form-control" multiple required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('userUpdate', ['user' => '__ID__']) }}" method="POST" id="editUserForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="editName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="editRoles" class="form-label">Assign Roles</label>
                                <select name="roles[]" id="editRoles" class="form-control" multiple required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Affichage des messages flash avec SweetAlert
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('status'))
                Swal.fire({
                    icon: "{{ session('status_type', 'success') }}",
                    title: "{{ session('status') }}",
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
        });

        // Confirmation suppression
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // Remplir le formulaire d'édition
        const editModal = document.getElementById('editUserModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-id');
            const userName = button.getAttribute('data-name');
            const userEmail = button.getAttribute('data-email');
            const userRoles = button.getAttribute('data-roles').split(',');

            const form = document.getElementById('editUserForm');
            form.action = form.action.replace('__ID__', userId);

            document.getElementById('editName').value = userName;
            document.getElementById('editEmail').value = userEmail;

            const rolesSelect = document.getElementById('editRoles');
            Array.from(rolesSelect.options).forEach(option => {
                option.selected = userRoles.includes(option.value);
            });
        });

        // Search functionality
        document.getElementById('userSearchInput').addEventListener('keyup', function () {
            let input = this.value.toLowerCase();
            let rows = document.querySelectorAll("#usersTable tbody tr");

            rows.forEach(row => {
                let nameCell = row.querySelector("td:nth-child(2)");
                let nameText = nameCell ? nameCell.textContent.toLowerCase() : "";
                row.style.display = nameText.includes(input) ? "" : "none";
            });
        });
    </script>
@endsection
