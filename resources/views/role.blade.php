@extends('layouts.apps')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Gestion des Rôles</h4>
                </div>

                <div class="card-body p-4">
                    <div class="mb-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                            <i class="fas fa-plus me-2"></i> Nouveau Rôle
                        </button>

                        <div class="input-group w-50">
                            <input type="text" class="form-control" placeholder="Rechercher un rôle..." id="roleSearchInput">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center" id="rolesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Description</th>
                                    <th>Permissions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->discription }}</td>
                                        <td>
                                            @foreach ($role->permissions as $permission)
                                                <span class="badge bg-info text-dark">{{ $permission->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <button class="btn btn-sm btn-outline-primary me-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editRoleModal"
                                                    data-id="{{ $role->id }}"
                                                    data-name="{{ $role->name }}"
                                                    data-description="{{ $role->discription }}"
                                                    data-permissions="{{ implode(',', $role->permissions->pluck('id')->toArray()) }}">
                                                    <i class="fas fa-edit"></i> Modifier
                                                </button>

                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmDelete({{ $role->id }})">
                                                    <i class="fas fa-trash"></i> Supprimer
                                                </button>

                                                <form id="delete-form-{{ $role->id }}"
                                                    action="{{ route('deleteRole', $role->id) }}"
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

    <!-- Modal: Ajouter un Rôle -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('addRole') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Ajouter un Rôle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="role_name" class="form-label">Nom du rôle</label>
                            <input type="text" class="form-control" name="name" id="role_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="role_description" class="form-label">Description</label>
                            <input type="text" class="form-control" name="description" id="role_description" required>
                        </div>
                        <fieldset class="border p-3">
                            <legend class="w-auto">Permissions</legend>
                            <div class="form-control" style="max-height: 200px; overflow-y: auto;">
                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}">
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Modifier un Rôle -->
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('updateRole', ['role' => '__ID__']) }}" method="POST" id="editRoleForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRoleModalLabel">Modifier le Rôle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editRoleName" class="form-label">Nom</label>
                            <input type="text" class="form-control" name="name" id="editRoleName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editRoleDescription" class="form-label">Description</label>
                            <input type="text" class="form-control" name="description" id="editRoleDescription" required>
                        </div>
                        <fieldset class="border p-3">
                            <legend class="w-auto">Permissions</legend>
                            <div id="editPermissions" class="form-control" style="max-height: 200px; overflow-y: auto;">
                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="editPermission_{{ $permission->id }}">
                                        <label class="form-check-label" for="editPermission_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Afficher une alerte SweetAlert après une action (ajout, update, suppression)
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

    // Rechercher dans le tableau des rôles
    document.getElementById('roleSearchInput').addEventListener('keyup', function () {
        let value = this.value.toLowerCase();
        document.querySelectorAll("#rolesTable tbody tr").forEach(row => {
            const name = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
            row.style.display = name.includes(value) ? "" : "none";
        });
    });

    // Pré-remplir le formulaire de modification
    const editRoleModal = document.getElementById('editRoleModal');
    editRoleModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const description = button.getAttribute('data-description');
        const permissions = button.getAttribute('data-permissions').split(',');

        const form = document.getElementById('editRoleForm');
        form.action = form.action.replace('__ID__', id);
        document.getElementById('editRoleName').value = name;
        document.getElementById('editRoleDescription').value = description;

        document.querySelectorAll('#editPermissions input').forEach(input => {
            input.checked = permissions.includes(input.value);
        });
    });

    // Confirmation avant suppression
    function confirmDelete(id) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Ce rôle sera supprimé définitivement.",
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
</script>
@endsection
