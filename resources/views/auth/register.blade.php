<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            background-image: url('image5.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="card shadow p-4" style="width: 400px;">
        <h2 class="text-center text-success mb-3">Inscription</h2>
        
        <form action="{{ route('register') }}" method="post">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input name="name" type="text" class="form-control" required>
                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input name="email" type="email" class="form-control" required>
                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input name="password" type="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmer le mot de passe</label>
                <input name="password_confirmation" type="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">S'inscrire</button>
        </form>

        <p class="mt-3 text-center">Déjà inscrit ? 
            <a href="{{ route('login') }}" class="text-success">Se connecter</a>
        </p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
