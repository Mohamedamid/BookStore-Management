@extends('layouts.apps')

@section('content')
    <div class="container">
        <!-- Section de gestion des utilisateurs -->
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0">{{ __('Gestion des utilisateurs') }}</h4>
                    </div>

                    <div class="card-body p-4">
                        <div class="mb-4 d-flex justify-content-between">
                            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#addUserModal">
                                <i class="fas fa-user-plus me-2"></i> Ajouter un utilisateur
                            </button>

                            <div class="input-group w-50">
                                <input type="text" class="form-control" placeholder="Rechercher un utilisateur..." id="userSearchInput">
                            </div>
                        </div>

                        <!-- Table centrée -->
                        <div class="table-responsive">
                            <table class="table table-hover mx-auto" id="usersTable">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Rôles</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar bg-primary rounded-circle me-3 text-white fw-bold d-flex align-items-center justify-content-center"
                                                        style="width:40px;height:40px;">
                                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                                    </div>
                                                    <span>{{ $user->name }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $user->email }}</td>
                                            <td class="text-center">
                                                @foreach ($user->roles as $role)
                                                    <span class="badge bg-info rounded-pill text-dark">{{ $role->name }}</span>
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal" data-id="{{ $user->id }}"
                                                        data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                                        data-roles="{{ implode(',', $user->roles->pluck('id')->toArray()) }}">
                                                        <i class="fas fa-edit"></i> Modifier
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDelete({{ $user->id }})">
                                                        <i class="fas fa-trash"></i> Supprimer
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

        <!-- Modale Ajouter un utilisateur -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('userStore') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Ajouter un nouvel utilisateur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                            <div class="mb-3">
                                <label for="roles" class="form-label">Attribuer des rôles</label>
                                <select name="roles[]" class="form-control" multiple required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer l'utilisateur</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modale Modifier un utilisateur -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('userUpdate', ['user' => '__ID__']) }}" method="POST" id="editUserForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Modifier l'utilisateur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editName" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="editName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="editRoles" class="form-label">Attribuer des rôles</label>
                                <select name="roles[]" id="editRoles" class="form-control" multiple required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Mettre à jour l'utilisateur</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- CDN SweetAlert2 -->
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

        // Confirmation de suppression
        function confirmDelete(id) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action ne peut pas être annulée.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // Remplir le formulaire de modification
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

        // Fonction de recherche
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
