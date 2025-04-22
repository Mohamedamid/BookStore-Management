@extends('layouts.apps')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Gestion des Clients</h4>
                    </div>

                    <div class="card-body p-4">
                        <div class="mb-4 d-flex justify-content-between">
                            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#addClientModal">
                                <i class="fas fa-plus me-2"></i> Nouveau client
                            </button>
                            <div class="input-group w-50">
                                <input type="text" class="form-control" placeholder="Rechercher des clients..."
                                    id="clientSearchInput">
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center" id="clientsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nom Complet</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Ville</th>
                                        <th>Date Inscription</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clientss as $client)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $client->nom }} {{ $client->prenom }}</td>
                                            <td>{{ $client->email }}</td>
                                            <td>{{ $client->telephone }}</td>
                                            <td>{{ $client->ville }}</td>
                                            <td>{{ $client->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal"
                                                        data-bs-target="#editClientModal" 
                                                        data-id="{{ $client->id }}"
                                                        data-nom="{{ $client->nom }}"
                                                        data-prenom="{{ $client->prenom }}"
                                                        data-email="{{ $client->email }}"
                                                        data-telephone="{{ $client->telephone }}"
                                                        data-ville="{{ $client->ville }}"
                                                        data-adresse="{{ $client->adresse }}">
                                                        <i class="fas fa-edit"></i> Modifier
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDelete({{ $client->id }})">
                                                        <i class="fas fa-trash"></i> Supprimer
                                                    </button>
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

        <!-- Modal Ajouter Client -->
        <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('clients.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addClientModalLabel">Ajouter un nouveau client</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Prénom</label>
                                <input type="text" name="prenom" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Téléphone</label>
                                <input type="text" name="telephone" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ville</label>
                                <input type="text" name="ville" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Adresse</label>
                                <input type="text" name="adresse" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer le client</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Modifier Client -->
        <div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" id="editClientForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editClientModalLabel">Modifier le client</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="editClientId">
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" id="editNom" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Prénom</label>
                                <input type="text" name="prenom" id="editPrenom" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" id="editEmail" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Téléphone</label>
                                <input type="text" name="telephone" id="editTelephone" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ville</label>
                                <input type="text" name="ville" id="editVille" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Adresse</label>
                                <input type="text" name="adresse" id="editAdresse" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Mettre à jour le client</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Message flash avec SweetAlert2
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('status'))
                Swal.fire({
                    icon: "{{ session('status_type', 'success') }}",
                    title: "{{ session('status') }}",
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif

            // Gestion de l'ajout de client
            // const addClientForm = document.querySelector('#addClientModal form');
            // if (addClientForm) {
            //     addClientForm.addEventListener('submit', function(e) {
            //         e.preventDefault();
            //         Swal.fire({
            //             title: 'Client ajouté avec succès!',
            //             icon: 'success',
            //             showConfirmButton: false,
            //             timer: 1500
            //         }).then(() => {
            //             this.submit();
            //         });
            //     });
            // }
        });

        // Confirmation de suppression avec SweetAlert2
        function confirmDelete(clientId) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Vous ne pourrez pas annuler cette action !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimez-le !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/clients/' + clientId;

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Pré-remplir le modal de modification
        const editModal = document.getElementById('editClientModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nom = button.getAttribute('data-nom');
            const prenom = button.getAttribute('data-prenom');
            const email = button.getAttribute('data-email');
            const telephone = button.getAttribute('data-telephone');
            const ville = button.getAttribute('data-ville');
            const adresse = button.getAttribute('data-adresse');

            const form = document.getElementById('editClientForm');
            form.setAttribute('action', '/clients/' + id);

            document.getElementById('editClientId').value = id;
            document.getElementById('editNom').value = nom;
            document.getElementById('editPrenom').value = prenom;
            document.getElementById('editEmail').value = email;
            document.getElementById('editTelephone').value = telephone;
            document.getElementById('editVille').value = ville;
            document.getElementById('editAdresse').value = adresse;
        });

        // Recherche en direct dans le tableau des clients
        document.getElementById('clientSearchInput').addEventListener('keyup', function () {
            const value = this.value.toLowerCase();
            const rows = document.querySelectorAll('#clientsTable tbody tr');

            rows.forEach(row => {
                const nom = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const telephone = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                
                row.style.display = nom.includes(value) || email.includes(value) || telephone.includes(value) 
                    ? '' 
                    : 'none';
            });
        });
    </script>
@endsection