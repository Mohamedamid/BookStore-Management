<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>403 - Accès refusé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .error-box {
            text-align: center;
        }
        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #dc3545;
        }
        .error-message {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .btn-home {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #0d6efd;
            color: white;
            border-radius: 8px;
        }
        .btn-home:hover {
            background-color: #084298;
        }
    </style>
</head>
<body>
    <div class="error-box">
        <div class="error-code">403</div>
        <div class="error-message">Accès refusé<br>Vous n'avez pas la permission d’accéder à cette page.</div>
        <a href="{{ route('home') }}" class="btn-home">Retour à l’accueil</a>
    </div>
</body>
</html>