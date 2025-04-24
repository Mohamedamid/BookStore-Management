@extends('layouts.apps')

@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list-alt me-2"></i>Liste des Commandes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="commandesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>N° Commande</th>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commandes as $commande)
                                <tr data-commande-id="{{ $commande->id }}">
                                    <td>CMD-{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $commande->client->nom }} {{ $commande->client->prenom }}</td>
                                    <td>{{ number_format($commande->total, 2) }} DH</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #commandesTable tbody tr {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    #commandesTable tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .commande-details-row {
        background-color: #f8fafc;
    }
    
    .badge.bg-success {
        background-color: #28a745 !important;
    }
    
    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #212529;
    }
    
    .badge.bg-danger {
        background-color: #dc3545 !important;
    }
    
    .modal-lg {
        max-width: 900px;
    }
</style>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Gestion du clic sur le bouton "Détails"
    $('.view-commande').on('click', function(e) {
        e.stopPropagation();
        const commandeId = $(this).data('commande-id');
        loadCommandeDetails(commandeId);
    });

    // Fonction pour charger les détails de la commande
    // function loadCommandeDetails(commandeId) {
    //     $.ajax({
    //         url: '/commandes/' + commandeId + '/details',
    //         method: 'GET',
    //         success: function(response) {
    //             // Remplir les informations de base
    //             $('#modalCommandeId').text('CMD-' + String(response.id).padStart(5, '0'));
    //             $('#clientName').text(response.client.nom + ' ' + response.client.prenom);
    //             $('#clientPhone').text(response.client.telephone);
    //             $('#clientAddress').text(response.client.adresse + ', ' + response.client.ville);
    //             $('#clientEmail').text(response.client.email || 'Non spécifié');
                
    //             // Informations de la commande
    //             $('#commandeDate').text(new Date(response.created_at).toLocaleDateString('fr-FR', {
    //                 day: '2-digit',
    //                 month: '2-digit',
    //                 year: 'numeric',
    //                 hour: '2-digit',
    //                 minute: '2-digit'
    //             }));
                
    //             $('#commandeTotal').text(response.total.toFixed(2) + ' DH');
                
    //             // Statut avec badge coloré
    //             let statusBadge = '';
    //             if(response.statut === 'complété') {
    //                 statusBadge = '<span class="badge bg-success">Complété</span>';
    //             } else if(response.statut === 'en cours') {
    //                 statusBadge = '<span class="badge bg-warning">En cours</span>';
    //             } else {
    //                 statusBadge = '<span class="badge bg-danger">Annulé</span>';
    //             }
    //             $('#commandeStatus').html(statusBadge);
                
    //             // Charger les articles de la commande
    //             const itemsTable = $('#commandeItemsTable tbody');
    //             itemsTable.empty();
                
    //             response.items.forEach((item, index) => {
    //                 const total = (item.prix - (item.prix * item.remise / 100)) * item.quantite;
                    
    //                 itemsTable.append(`  
    //                     <tr>
    //                         <td>${index + 1}</td>
    //                         <td>${item.reference}</td>
    //                         <td>${item.nom}</td>
    //                         <td class="text-center">${item.quantite}</td>
    //                         <td class="text-center">${item.prix.toFixed(2)} DH</td>
    //                         <td class="text-center">${item.remise}%</td>
    //                         <td class="text-center">${total.toFixed(2)} DH</td>
    //                     </tr>
    //                 `);
    //             });
                
    //             // Afficher le modal
    //             $('#commandeModal').modal('show');
    //         },
    //         error: function(xhr) {
    //             alert('Erreur lors du chargement des détails de la commande');
    //             console.error(xhr);
    //         }
    //     });
    // }

    // Bouton d'impression
    $('#printCommandeBtn').on('click', function() {
        window.print();
    });
});
</script>
@endsection
