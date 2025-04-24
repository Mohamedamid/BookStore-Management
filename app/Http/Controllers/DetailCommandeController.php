<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class DetailCommandeController extends Controller
{
    public function index()
    {
        $userr = auth()->user();
        $fullName = $userr->name;
        $firstName = explode(' ', $fullName)[0];

        $commandes = Commande::with(['client'])->orderBy('created_at', 'desc')->get();

        return view('Detail_Commande', compact('commandes'  , 'firstName'));
    }

    public function show($id)
    {
        $commande = Commande::with(['client'])->findOrFail($id);

        return response()->json([
            'commande' => $commande,
            'client' => $commande->client,
            'created_at' => $commande->created_at->format('d/m/Y H:i')
        ]);
    }
}
