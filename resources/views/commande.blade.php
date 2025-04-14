@extends('layouts.apps')

@section('content')
    <style>
        body {
            background-color: #f0f4f8;
        }

        .commande-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            max-width: 800px;
            margin: auto;
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
        }

        .btn-custom {
            border-radius: 8px;
            padding: 10px 25px;
        }

        .btn-add {
            background-color: #ecf0f1;
            color: #2c3e50;
            border: 1px solid #bdc3c7;
        }

        .btn-add:hover {
            background-color: #d0d7de;
        }

        .btn-submit {
            background-color: #0d6efd;
            color: white;
        }

        .btn-submit:hover {
            background-color: #084298;
        }

        .article-group {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #0d6efd;
        }
    </style>

    <div class="container mt-5">
        <div class="commande-card">
            <h2 class="text-center mb-4 text-primary">Créer une Nouvelle Commande</h2>

            <form action="{{ route('create.store') }}" method="POST">
                @csrf

                <div class="form-group mb-4">
                    <label for="client_id" class="form-label">Client</label>
                    <select name="client_id" id="client_id" class="form-control" required>
                        <option value="">-- Sélectionner un client --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="articles">
                    <div class="article-group">
                        <label class="form-label">Produit</label>
                        <select name="articles[0][article_id]" class="form-control" required>
                            <option value="">-- Sélectionner un produit --</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}">{{ $book->title }} - Livre</option>
                            @endforeach
                            @foreach($fournitures as $fourniture)
                                <option value="{{ $fourniture->id }}">{{ $fourniture->name }} - Fourniture</option>
                            @endforeach
                        </select>
                        <input type="number" name="articles[0][quantity]" class="form-control mt-2" placeholder="Quantité" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" id="add-article" class="btn btn-add btn-custom">+ Ajouter un article</button>
                    <button type="submit" class="btn btn-submit btn-custom">Valider la commande</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let index = 1;
        document.getElementById('add-article').addEventListener('click', function () {
            const articleGroup = document.createElement('div');
            articleGroup.classList.add('article-group');
            articleGroup.innerHTML = `
                <label class="form-label">Produit</label>
                <select name="articles[${index}][article_id]" class="form-control" required>
                    <option value="">-- Sélectionner un produit --</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}">{{ $book->title }} - Livre</option>
                    @endforeach
                    @foreach($fournitures as $fourniture)
                        <option value="{{ $fourniture->id }}">{{ $fourniture->name }} - Fourniture</option>
                    @endforeach
                </select>
                <input type="number" name="articles[${index}][quantity]" class="form-control mt-2" placeholder="Quantité" required>
            `;
            document.getElementById('articles').appendChild(articleGroup);
            index++;
        });
    </script>
@endsection
