@extends('layouts.apps')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Gestion des Livres</h4>
                </div>

                <div class="card-body p-4">
                    <div class="mb-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" 
                        data-bs-target="#addBookModal">
                        <i class="fas fa-plus me-2"></i> Nouveau livre
                        </button>
                        <div class="input-group w-50">
                            <input type="text" class="form-control" placeholder="Rechercher des livres..." id="bookSearchInput">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center" id="booksTable">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Titre</th>
                                    <th>Niveau académique</th>
                                    <th>Type</th>
                                    <th>Quantité</th>
                                    <th>Prix</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($livres as $livre)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $livre->title }}</td>
                                        <td>{{ $livre->niveau_academique }}</td>
                                        <td><span class="badge bg-secondary">{{ $livre->type }}</span></td>
                                        <td>
                                            <span class="badge bg-{{ $livre->quantity > 50 ? 'success' : ($livre->quantity > 10 ? 'warning' : 'danger') }}">
                                                {{ $livre->quantity }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($livre->price, 2) }} DH</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal"
                                                    data-bs-target="#editBookModal"
                                                    data-id="{{ $livre->id }}"
                                                    data-title="{{ $livre->title }}"
                                                    data-niveau="{{ $livre->niveau_academique }}"
                                                    data-type="{{ $livre->type }}"
                                                    data-quantity="{{ $livre->quantity }}"
                                                    data-price="{{ $livre->price }}">
                                                    <i class="fas fa-edit"></i> Modifier
                                                </button>

                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $livre->id }})">
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

    <!-- Modal Ajouter Livre -->
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('book.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBookModalLabel">Ajouter un nouveau livre</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Niveau académique</label>
                            <input type="text" name="niveau_academique" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <input type="text" name="type" class="form-control" required>
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
                        <button type="submit" class="btn btn-primary">Enregistrer le livre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Modifier Livre -->
    <div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="editBookForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBookModalLabel">Modifier le livre</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editBookId">
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <input type="text" name="title" id="editTitle" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Niveau académique</label>
                            <input type="text" name="niveau_academique" id="editNiveau" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <input type="text" name="type" id="editType" class="form-control" required>
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
                        <button type="submit" class="btn btn-primary">Mettre à jour le livre</button>
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
    function confirmDelete(bookId) {
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
                form.action = '/book/' + bookId;

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
    const editModal = document.getElementById('editBookModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        const niveau = button.getAttribute('data-niveau');
        const type = button.getAttribute('data-type');
        const quantity = button.getAttribute('data-quantity');
        const price = button.getAttribute('data-price');

        const form = document.getElementById('editBookForm');
        form.setAttribute('action', '/book/' + id);

        document.getElementById('editBookId').value = id;
        document.getElementById('editTitle').value = title;
        document.getElementById('editNiveau').value = niveau;
        document.getElementById('editType').value = type;
        document.getElementById('editQuantity').value = quantity;
        document.getElementById('editPrice').value = price;
    });

    // Recherche en direct dans le tableau des livres
    document.getElementById('bookSearchInput').addEventListener('keyup', function () {
        const value = this.value.toLowerCase();
        const rows = document.querySelectorAll('#booksTable tbody tr');

        rows.forEach(row => {
            const title = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            row.style.display = title.includes(value) ? '' : 'none';
        });
    });
</script>
@endsection
