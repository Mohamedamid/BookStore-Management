<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Book;
use App\Models\Fourniture;

class CommandeController extends Controller
{
    /**
     * Afficher le formulaire POS.
     */
    public function create()
    {
        $userr = auth()->user();
        $fullName = $userr->name; // مثال: "Mohamed Amine"
        $firstName = explode(' ', $fullName)[0]; // Exemple: "Mohamed Amine"
        $clients = Client::all();
        $books = Book::all();
        $fournitures = Fourniture::all();

        return view('commande', compact('clients', 'books', 'fournitures' , 'firstName'));
    }
}
