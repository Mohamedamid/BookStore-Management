@extends('layouts.apps')

@section('content')
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-8">
                <!-- Sélection du client -->
                <div class="client-selection-container bg-white p-3 rounded shadow-sm mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small text-center d-block">CLIENT</label>
                            <!-- Center label text -->
                            <select class="form-select border-2 border-primary py-2 text-center" id="clientSelect">
                                <!-- Center text in select -->
                                <option value="">Rechercher un client...</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" data-nom="{{ $client->nom }} {{ $client->prenom }}"
                                        data-tel="{{ $client->telephone }}" data-ville="{{ $client->ville }}"
                                        data-email="{{ $client->email }}" data-adresse="{{ $client->adresse }}">
                                        {{ $client->nom }} {{ $client->prenom }} | {{ $client->telephone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <div class="client-info-card d-none p-3 bg-white rounded-3 shadow-sm border border-2 border-primary border-opacity-10"
                                id="clientBadge">
                                <div class="d-flex align-items-start">
                                    <div class="client-avatar bg-primary bg-opacity-10 text-primary rounded-circle d-flex 
                                              align-items-center justify-content-center me-3"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-user fs-5"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="mb-0 fw-bold text-dark" id="clientName"></h5>
                                            <button class="btn btn-sm btn-light rounded-circle" id="btnClearClient"
                                                title="Effacer">
                                                <i class="fas fa-times text-danger"></i>
                                            </button>
                                        </div>

                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-primary bg-opacity-10 text-primary me-2">
                                                <i class="fas fa-phone-alt me-1"></i>
                                                <span id="clientPhone"></span>
                                            </span>
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                <span id="clientCity"></span>
                                            </span>
                                        </div>

                                        <div class="client-additional-info">
                                            <div class="d-flex align-items-center mb-1">
                                                <small class="text-muted me-2">
                                                    <i class="far fa-envelope me-1"></i>
                                                    <span id="clientEmail"></span>
                                                </small>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-home me-1"></i>
                                                    <span id="clientAdresse"></span>
                                                </small>
                                            </div>
                                        </div>
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
                                <input type="number" id="inputQte" class="form-control form-control-lg border-2" value="1"
                                    min="1">
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

    <style>
        .fixed-panel {
            position: fixed;
            right: 0;
            top: 70px;
            width: 33.333333%;
            height: calc(100vh - 70px);
            overflow-y: auto;
            background: white;
            z-index: 1000;
            padding: 1rem;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            z-index: 1030 !important;
        }

        .client-selection-container {
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .client-info-card {
            transition: all 0.3s ease;
            border-left: 3px solid var(--bs-primary) !important;
        }

        .client-info-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.1) !important;
            transform: translateY(-2px);
        }

        .client-avatar {
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .client-additional-info {
            background-color: #f8fafc;
            padding: 0.5rem;
            border-radius: 0.5rem;
            margin-top: 0.5rem;
        }

        #btnClearClient {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        #btnClearClient:hover {
            background-color: #f8d7da !important;
        }

        .form-select,
        .form-control {
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        }

        #numPad .btn {
            font-weight: 500;
            transition: all 0.2s;
        }

        #numPad .btn:active {
            transform: scale(0.95);
        }

        #tableItems tbody tr {
            transition: background-color 0.2s;
        }

        #tableItems tbody tr:hover {
            background-color: #f8f9fa;
        }

        table {
            border-radius: 0.5rem;
            overflow: hidden;
            text-align: center;
        }

        @media (max-width: 992px) {
            .fixed-panel {
                position: static;
                width: 100%;
                height: auto;
            }
        }
    </style>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Gestion du client
            $('#clientSelect').on('change', function () {
                const id = $(this).val();
                const selectedOption = $(this).find('option:selected');

                if (id) {
                    // إخفاء خانة تحديد العميل
                    $('#clientSelect').hide();

                    // إظهار بطاقة العميل
                    $('#clientBadge').removeClass('d-none');

                    // تحديث تفاصيل العميل
                    $('#clientName').text(selectedOption.data('nom'));
                    $('#clientPhone').text(selectedOption.data('tel'));
                    $('#clientCity').text(selectedOption.data('ville'));
                    $('#clientEmail').text(selectedOption.data('email') || 'Non spécifié');
                    $('#clientAdresse').text(selectedOption.data('adresse') || 'Non spécifiée');
                } else {
                    // إعادة إظهار خانة تحديد العميل إذا لم يتم اختيار عميل
                    $('#clientSelect').show();

                    // إخفاء تفاصيل العميل
                    $('#clientBadge').addClass('d-none');
                }
            });

            $('#btnClearClient').on('click', function () {

                $('#clientSelect').show();

                $('#clientBadge').addClass('d-none');

                $('#clientSelect').val('');
            });

            $('#numPad').on('click', '.num-btn', function () {
                const clickedValue = $(this).data('value');
                const inputField = $('#inputQte');
                let currentValue = inputField.val();

                if (currentValue === '0' || currentValue === '1') {
                    inputField.val(clickedValue);
                } else {
                    inputField.val(currentValue + clickedValue);
                }
                inputField.focus();
            });

            $('#btnClear').on('click', function () {
                $('#inputQte').val('1').focus();
            });

            // Recherche et ajout de produit
            let index = 1;

            function addProductToTable(product) {
                let qte = parseInt($('#inputQte').val()) || 1;
                if (qte < 1) qte = 1;

                const remise = parseInt($('#inputRemise').val()) || 0;
                const total = (product.price - (product.price * remise / 100)) * qte;

                const row = `
                    <tr data-reference="${product.reference}">
                        <td class="text-center">${index}</td>
                        <td class="text-center">${product.reference}</td>
                        <td>${product.name}</td>
                        <td class="text-center">${qte}</td>
                        <td class="text-center">${product.price} DH</td>
                        <td class="text-center">${remise}%</td>
                        <td class="text-center">${total.toFixed(2)} DH</td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-sm remove-item">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;

                $('#tableItems tbody').append(row);
                updateTotal();
                index++;
                $('#inputQte').val('1');
                $('#inputSearch').val('').focus();
            }

            // Ajout via bouton
            $('#btnAddItem').on('click', function () {
                const ref = $('#inputSearch').val().trim();
                if (!ref) return;

                $.get('/produit/find/' + ref)
                    .done(addProductToTable)
                    .fail(function () {
                        alert('Produit introuvable');
                    });
            });

            // Ajout via touche Entrée
            $('#inputSearch').on('keypress', function (e) {
                if (e.which === 13) {
                    $('#btnAddItem').click();
                }
            });

            // Suppression de ligne
            $(document).on('click', '.remove-item', function () {
                $(this).closest('tr').remove();
                updateTotal();
            });

            // Mise à jour du total
            function updateTotal() {
                let total = 0;
                $('#tableItems tbody tr').each(function () {
                    const t = parseFloat($(this).find('td:nth-child(7)').text().replace(' DH', ''));
                    if (!isNaN(t)) total += t;
                });
                $('#totalAmount').text(total.toFixed(2) + ' DH');
            }

            // Enregistrement de la vente
            $('#btnSubmit').on('click', function () {
                const clientId = $('#clientSelect').val();

                if (!clientId) {
                    alert('Veuillez sélectionner un client');
                    return;
                }

                const items = [];
                $('#tableItems tbody tr').each(function () {
                    items.push({
                        reference: $(this).data('reference'),
                        name: $(this).find('td:nth-child(3)').text(),
                        quantity: parseInt($(this).find('td:nth-child(4)').text()),
                        price: parseFloat($(this).find('td:nth-child(5)').text().replace(' DH', '')),
                        discount: parseInt($(this).find('td:nth-child(6)').text().replace('%', ''))
                    });
                });

                if (items.length === 0) {
                    alert('Veuillez ajouter au moins un produit');
                    return;
                }

                const totalAmount = parseFloat($('#totalAmount').text().replace(' DH', ''));

                $.ajax({
                    url: '/commandes',
                    method: 'POST',
                    data: {
                        client_id: clientId,
                        items: items,
                        total: totalAmount,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        alert(res.message);
                        $('#clientSelect').val('').trigger('change');
                        $('#tableItems tbody').empty();
                        updateTotal();
                        index = 1;
                    },
                    error: function (err) {
                        console.error(err);
                        alert('Erreur: ' + (err.responseJSON?.message || 'Erreur inconnue'));
                    }
                });
            });

            // Impression
            $('#btnPrint').on('click', function () {
                window.print();
            });
        });
    </script>
@endsection