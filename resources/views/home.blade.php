@extends('layouts.apps')

@section('content')
    <style>
        body {
            background-color: #f5f7fa;
        }

        .dashboard-card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            font-size: 1.5rem;
        }

        .section-title {
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
        }
    </style>

    <!-- Statistiques -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="dashboard-card d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Total des Commandes</p>
                    <h3 class="fw-bold text-primary">{{ $totalCommandes ?? 0 }}</h3>
                </div>
                <div class="icon-circle bg-primary text-white">
                    <i class="fas fa-receipt"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Price des commande total </p>
                    <h3 class="fw-bold text-primary">{{ $totalPriceCommandes ?? 0 }} DH</h3>
                </div>
                <div class="icon-circle bg-info text-white">
                    <i class="fa fa-coins"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Commandes d'aujourd'hui</p>
                    <h3 class="fw-bold text-primary">{{ $commandesAujourdHui ?? 0 }}</h3>
                </div>
                <div class="icon-circle bg-info text-white">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Price des commande d'aujourd'hui</p>
                    <h3 class="fw-bold text-primary">{{ $totalPriceCommandesAujourdHui ?? 0 }} DH</h3>
                </div>
                <div class="icon-circle bg-info text-white">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Les Clients</p>
                    <h3 class="fw-bold text-primary">{{ $totalClients ?? 0 }}</h3>
                </div>
                <div class="icon-circle bg-info text-white">
                    <i class="fas fa-id-card"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Livres (&lt; 50)</p>
                    <h3 class="fw-bold text-success">{{ $TotalLivre ?? 0 }}</h3>
                </div>
                <div class="icon-circle bg-success text-white">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Fournitures (&lt; 50)</p>
                    <h3 class="fw-bold text-warning">{{ $TotalFourniture ?? 0 }}</h3>
                </div>
                <div class="icon-circle bg-warning text-white">
                    <i class="fa-solid fa-pen-ruler"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Listes -->
    <div class="row mt-5">
        <!-- Livres -->
        <div class="col-lg-6 mb-4">
            <div class="dashboard-card">
                <h5 class="section-title"><i class="fas fa-book"></i> Livres avec quantité &lt; 50</h5>
                @if ($booksUnder50->count())
                    <ul class="list-group list-group-flush">
                        @foreach ($booksUnder50 as $book)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $book->title }}</span>
                                <span class="badge bg-danger">Quantité : {{ $book->quantity }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Aucun livre avec une quantité inférieure à 50.</p>
                @endif
            </div>
        </div>

        <!-- Fournitures -->
        <div class="col-lg-6 mb-4">
            <div class="dashboard-card">
                <h5 class="section-title"><i class="fa-solid fa-pen-ruler"></i> Fournitures avec quantité &lt; 50</h5>
                @if ($fournituresUnder50->count())
                    <ul class="list-group list-group-flush">
                        @foreach ($fournituresUnder50 as $fourniture)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $fourniture->name }}</span>
                                <span class="badge bg-warning">Quantité : {{ $fourniture->quantity }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Aucune fourniture avec une quantité inférieure à 50.</p>
                @endif
            </div>
        </div>
    </div>
@endsection