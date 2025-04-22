@extends('layouts.apps')

@section('content')
<link rel="stylesheet" href="/css/commande.css">
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-8">
            <!-- Sélection du client -->
            <div class="client-selection-container bg-white p-3 rounded shadow-sm mb-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small">CLIENT</label>
                        <select class="form-select border-2 border-primary py-2" id="clientSelect">
                            <option value="">Rechercher un client...</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" 
                                    data-nom="{{ $client->nom }} {{ $client->prenom }}"
                                    data-tel="{{ $client->telephone }}"
                                    data-ville="{{ $client->ville }}"
                                    data-email="{{ $client->email }}"
                                    data-adresse="{{ $client->adresse }}">
                                    {{ $client->nom }} {{ $client->prenom }} | {{ $client->telephone }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mt-3 mt-md-0">
                        <div class="client-card d-none align-items-center p-3 bg-light rounded" id="clientBadge">
                            <div class="client-avatar bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center" 
                                style="width: 45px; height: 45px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="client-details ms-3 flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold text-dark" id="clientName"></h6>
                                    <button class="btn btn-sm btn-outline-primary py-0 px-2" id="btnMoreInfo">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                                <div class="d-flex flex-wrap mt-1">
                                    <span class="badge bg-light text-dark me-2 mb-1" id="clientPhone"></span>
                                    <span class="badge bg-light text-primary" id="clientCity"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des produits -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered mt-3" id="tableItems">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th width="5%" class="text-center">N°</th>
                            <th width="15%" class="text-center">Référence</th>
                            <th width="25%">Produit</th>
                            <th width="10%" class="text-center">Quantité</th>
                            <th width="10%" class="text-center">Prix</th>
                            <th width="10%" class="text-center">Remise</th>
                            <th width="15%" class="text-center">Total</th>
                            <th width="10%" class="text-center">Suppr.</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot class="table-group-divider">
                        <tr>
                            <td colspan="6" class="text-end fw-bold">Total général</td>
                            <td colspan="2" class="text-danger fw-bold text-center" id="totalAmount">0.00 DH</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Colonne de droite -->
        <div class="col-md-4 fixed-panel">
            <div class="sticky-column">
                <div class="d-flex justify-content-between ">
                    <button id="btnSubmit" class="btn btn-success btn-lg flex-grow-1 me-2">
                        <i class="fas fa-save me-1"></i> Enregistrer
                    </button>
                    <button class="btn btn-warning btn-lg" id="btnPrint">
                        <i class="fas fa-print"></i>
                    </button>
                </div>

                <div class="bg-white p-2 rounded shadow-sm">
                    <div class="">
                        <label class="form-label text-muted small">RECHERCHE PRODUIT</label>
                        <div class="input-group">
                            <input type="text" id="inputSearch" class="form-control form-control-lg border-2" 
                                   placeholder="Code-barres" autocomplete="off">
                        </div>
                        <button id="btnAddItem" class="btn btn-primary btn-lg w-100 mt-2">
                            <i class="fas fa-plus me-1"></i> Ajouter
                        </button>
                    </div>

                    <div class="row g-2 ">
                        <div class="col-6">
                            <label class="form-label text-muted small">QUANTITÉ</label>
                            <input type="number" id="inputQte" class="form-control form-control-lg border-2" value="1" min="1">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">REMISE</label>
                            <select id="inputRemise" class="form-select form-select-lg border-2">
                                @for ($i = 0; $i <= 50; $i += 5)
                                    <option value="{{ $i }}">{{ $i }}%</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Pavé numérique -->
                <div class="bg-white p-2 rounded shadow-sm">
                    <div class="row g-2" id="numPad">
                        @foreach ([7, 8, 9, 4, 5, 6, 1, 2, 3] as $btn)
                            <div class="col-4">
                                <button type="button" class="btn btn-light btn-lg w-100 py-3 num-btn" 
                                    data-value="{{ $btn }}">
                                    {{ $btn }}
                                </button>
                            </div>
                        @endforeach
                        <div class="col-6">
                            <button type="button" class="btn btn-light btn-lg w-100 py-3 num-btn" data-value="0">
                                0
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-danger btn-lg w-100 py-3" id="btnClear">
                                <i class="fas fa-undo"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal des détails du client -->
<div class="modal fade" id="clientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-circle me-2"></i>Détails du client
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted small mb-1">CODE CLIENT</h6>
                        <p class="fw-bold" id="modalCodeClient"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted small mb-1">NOM COMPLET</h6>
                        <p class="fw-bold" id="modalNomClient"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted small mb-1">TÉLÉPHONE</h6>
                        <p class="fw-bold" id="modalTelClient"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted small mb-1">VILLE</h6>
                        <p class="fw-bold" id="modalVilleClient"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted small mb-1">EMAIL</h6>
                        <p class="fw-bold" id="modalEmailClient"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted small mb-1">ADRESSE</h6>
                        <p class="fw-bold" id="modalAdresseClient"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Fermer
                </button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/js/ajax_commande.js"></script>
@endsection