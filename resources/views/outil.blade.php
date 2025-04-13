@extends('layouts.apps')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Gestion des Fournitures</h4>
                    </div>

                    <div class="card-body p-4">
                        <div class="mb-4 d-flex justify-content-between">
                            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#addFournitureModal">
                                <i class="fas fa-plus me-2"></i> Nouvelle fourniture
                            </button>
                            <div class="input-group w-50">
                                <input type="text" class="form-control" placeholder="Rechercher des fournitures..."
                                    id="fournitureSearchInput">
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center" id="fournituresTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nom</th>
                                        <th>Quantité</th>
                                        <th>Prix</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fournitures as $fourniture)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $fourniture->name }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $fourniture->quantity > 50 ? 'success' : ($fourniture->quantity > 10 ? 'warning' : 'danger') }}">
                                                    {{ $fourniture->quantity }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($fourniture->price, 2) }} DH</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal"
                                                        data-bs-target="#editFournitureModal" data-id="{{ $fourniture->id }}"
                                                        data-name="{{ $fourniture->name }}" data-quantity="{{ $fourniture->quantity }}"
                                                        data-price="{{ $fourniture->price }}">
                                                        <i class="fas fa-edit"></i> Modifier
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDelete({{ $fourniture->id }})">
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

        <!-- Modal Ajouter Fourniture -->
        <div class="modal fade" id="addFournitureModal" tabindex="-1" aria-labelledby="addFournitureModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('fourniture.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addFournitureModalLabel">Ajouter une nouvelle fourniture</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quantité</label>
                                <input type="number" name="quantity" class="form-control" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Prix (DH)</label>
                                <input type="number" name="price" class="form-control" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer la fourniture</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Modifier Fourniture -->
        <div class="modal fade" id="editFournitureModal" tabindex="-1" aria-labelledby="editFournitureModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" id="editFournitureForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editFournitureModalLabel">Modifier la fourniture</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="editFournitureId">
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="name" id="editName" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quantité</label>
                                <input type="number" name="quantity" id="editQuantity" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Prix (DH)</label>
                                <input type="number" name="price" id="editPrice" class="form-control" step="0.01" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Mettre à jour la fourniture</button>
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
        });

        // Confirmation de suppression avec SweetAlert2
        function confirmDelete(fournitureId) {
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
                    form.action = '/outil/' + fournitureId;

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
        const editModal = document.getElementById('editFournitureModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const quantity = button.getAttribute('data-quantity');
            const price = button.getAttribute('data-price');

            const form = document.getElementById('editFournitureForm');
            form.setAttribute('action', '/outil/' + id);

            document.getElementById('editFournitureId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editQuantity').value = quantity;
            document.getElementById('editPrice').value = price;
        });

        // Recherche en direct dans le tableau des fournitures
        document.getElementById('fournitureSearchInput').addEventListener('keyup', function () {
            const value = this.value.toLowerCase();
            const rows = document.querySelectorAll('#fournituresTable tbody tr');

            rows.forEach(row => {
                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                row.style.display = name.includes(value) ? '' : 'none';
            });
        });
    </script>
@endsection
