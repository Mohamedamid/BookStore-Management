@extends('layouts.apps')

@section('content')
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Book Management</h4>
                </div>

                <div class="card-body p-4">
                    <div class="mb-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" 
                        data-bs-target="#addBookModal">
                        <i class="fas fa-plus me-2"></i>  Add New Book
                        </button>
                        <div class="input-group w-50">
                            <input type="text" class="form-control" placeholder="Search books..." id="bookSearchInput">
                            <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="booksTable">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Academic Level</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
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
                                            <span class="badge bg-{{ $livre->quantity > 10 ? 'success' : ($livre->quantity > 0 ? 'warning' : 'danger') }}">
                                                {{ $livre->quantity }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($livre->price, 2) }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal"
                                                    data-bs-target="#editBookModal"
                                                    data-id="{{ $livre->id }}"
                                                    data-title="{{ $livre->title }}"
                                                    data-niveau="{{ $livre->niveau_academique }}"
                                                    data-type="{{ $livre->type }}"
                                                    data-quantity="{{ $livre->quantity }}"
                                                    data-price="{{ $livre->price }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>

                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $livre->id }})">
                                                    <i class="fas fa-trash"></i> Delete
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

    <!-- Add Book Modal -->
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('book.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBookModalLabel">Add New Book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Academic Level</label>
                            <input type="text" name="niveau_academique" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <input type="text" name="type" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price ($)</label>
                            <input type="number" name="price" class="form-control" min="0" step="0.01" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Book Modal -->
    <div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="editBookForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBookModalLabel">Edit Book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editBookId">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" id="editTitle" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Academic Level</label>
                            <input type="text" name="niveau_academique" id="editNiveau" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <input type="text" name="type" id="editType" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="editQuantity" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price ($)</label>
                            <input type="number" name="price" id="editPrice" class="form-control" step="0.01" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<script>
    // Flash message with SweetAlert2
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

    // SweetAlert2 Delete Confirmation
    function confirmDelete(bookId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
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

    // Pre-fill Edit Modal
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

    // Live search in the book table
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
