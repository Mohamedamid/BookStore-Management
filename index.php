<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style/style.css">
    <title>BookStore - Accueil</title>
</head>
<body>
    <div class="cart-icon" onclick="toggleCart()">
        🛒
        <span class="cart-count">0</span>
    </div>

    <nav>
        <ul>
            <li><a href="#accueil">Accueil</a></li>
            <li><a href="#livres">Livres</a></li>
            <li><a href="#apropos">À propos</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>

    <section class="hero">
        <div>
            <h1>BookStore</h1>
            <p>Découvrez notre collection unique</p>
        </div>
    </section>

    <div class="books-grid" id="books-container"></div>

    <div id="cartModal" class="modal">
        <div class="modal-content">
            <h2>Votre Panier</h2>
            <div id="cartItems"></div>
            <button class="btn" onclick="checkout()">Payer</button>
            <button class="btn" onclick="toggleCart()">Fermer</button>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 BookStore</p>
    </footer>

    <script src="./assets/js/main.js">
    </script>
</body>
</html>