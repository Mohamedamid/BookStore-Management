<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="icon" href="images/image1.jpg">
    <title>BookStore</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <!-- Super Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <a class="navbar-brand" href="/home">BookStore</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Basculer la navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" id="dashboardLink" href="/home">
                        <i class="fas fa-tachometer-alt"></i> Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="usersLink" href="/user">
                        <i class="fas fa-users"></i> Utilisateurs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="rolesLink" href="/role">
                        <i class="fas fa-user-tag"></i> Rôles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="permissionsLink" href="/permission">
                        <i class="fas fa-key"></i> Permissions
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="livresLink" href="/livre">
                        <i class="fas fa-book"></i> Livres
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="outilsLink" href="/outil">
                    <i class="fa-solid fa-pen-ruler"></i> Fournitures
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="clientsLink" href="/client">
                        <i class="fas fa-id-card"></i> Clients
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="commandesLink" href="/commande">
                        <i class="fas fa-shop"></i> Commandes
                    </a>
                </li>
            </ul>

            <!-- Formulaire de Recherche -->
            <form class="search-form">
                <input class="form-control" type="search" placeholder="Rechercher..." aria-label="Search">
                <button class="search-btn" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <!-- Menu déroulant Profil Utilisateur -->
            <div class="user-profile dropdown">
                <a class="dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="d-none d-lg-inline text-white ms-1">{{ $firstName }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i>Profil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Paramètres</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="logout"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
                </ul>
            </div>

            <!-- Bouton Déconnexion pour mobile -->
            <div class="d-lg-none mt-3">
                <a class="nav-link logout-btn" href="logout">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </div>
    </nav>


    <!-- Contenu Principal -->
    <main class="main-content container-fluid">
        @yield('content')
    </main>
    <!-- Bootstrap 5 JS et dépendances -->
    <script src="js/dashboard.js"></script>
    <script src="js/navbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    
</body>

</html>
