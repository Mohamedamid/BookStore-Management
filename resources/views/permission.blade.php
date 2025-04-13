@extends('layouts.apps')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0">Gestion des Permissions</h4>
                    </div>

                    <div class="card-body p-4">
                        <div class="mb-4 d-flex justify-content-between">
                            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#addPermissionModal">
                                <i class="fas fa-plus me-2"></i> Nouvelle Permission
                            </button>

                            <div class="input-group w-50">
                                <input type="text" class="form-control" placeholder="Rechercher une permission..."
                                    id="permissionSearchInput">
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center" id="permissionsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nom</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" class="btn btn-sm btn-outline-primary me-2"
                                                        data-bs-toggle="modal" data-bs-target="#editPermissionModal"
                                                        data-id="{{ $permission->id }}" data-name="{{ $permission->name }}">
                                                        <i class="fas fa-edit"></i> Modifier
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDelete({{ $permission->id }})">
                                                        <i class="fas fa-trash"></i> Supprimer
                                                    </button>

                                                    <form id="delete-form-{{ $permission->id }}"
                                                        action="{{ route('deletePermission', $permission->id) }}" method="POST"
                                                        style="display: none;">
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

        <!-- Modal: Ajouter -->
        <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('addPermission') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPermissionModalLabel">Ajouter une Permission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="permissionName" class="form-label">Nom</label>
                                <input type="text" class="form-control" name="name" id="permissionName" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Modifier -->
        <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('updatePermission', ['permission' => '__ID__']) }}" method="POST"
                        id="editPermissionForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPermissionModalLabel">Modifier la Permission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editPermissionName" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="editPermissionName" name="name" required>
                            </div>
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

    <!-- SweetAlert2 CDN -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

    <script>
        // SweetAlert pour les messages flash (succès, erreur...)
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

        // Fonction suppression avec confirmation SweetAlert
        function confirmDelete(id) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action est irréversible.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-form-' + id);
                    if (form) {
                        form.submit();
                    } else {
                        Swal.fire('Erreur', 'Formulaire introuvable.', 'error');
                    }
                }
            });
        }

        // Pré-remplir le modal de modification
        const editModal = document.getElementById('editPermissionModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');

            const form = document.getElementById('editPermissionForm');
            const originalAction = form.getAttribute('action');
            const newAction = originalAction.replace('__ID__', id);
            form.setAttribute('action', newAction);

            document.getElementById('editPermissionName').value = name;
        });

        // Recherche en direct dans le tableau
        document.getElementById('permissionSearchInput').addEventListener('keyup', function () {
            const input = this.value.toLowerCase();
            const rows = document.querySelectorAll("#permissionsTable tbody tr");

            rows.forEach(row => {
                const nameCell = row.querySelector("td:nth-child(2)");
                const nameText = nameCell ? nameCell.textContent.toLowerCase() : "";
                row.style.display = nameText.includes(input) ? "" : "none";
            });
        });
    </script>
@endsection