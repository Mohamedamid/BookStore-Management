<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use App\Models\CommandeItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function create()
    {
        $userr = auth()->user();
        $fullName = $userr->name;
        $firstName = explode(' ', $fullName)[0];
        $clients = Client::all();

        return view('commande', compact('clients', 'firstName'));
    }

public function store(Request $request)
{
    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'items' => 'required|array|min:1',
        'total' => 'required|numeric'
    ]);

    DB::beginTransaction();

    try {

        $commande = Commande::create([
            'client_id' => $request->client_id,
            'total' => $request->total
        ]);

        foreach ($request->items as $item) {
            CommandeItem::create([
                'commande_id' => $commande->id,
                'barcode' => $item['reference'],
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'discount' => $item['discount']
            ]);
        }

        DB::commit();

        return response()->json(['message' => 'Commande enregistrée avec succès']);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'message' => 'Erreur lors de l’enregistrement',
            'error' => $e->getMessage()
        ], 500);
    }
}


    public function getClientInfo($id)
    {
        $client = Client::findOrFail($id);
        return response()->json($client);
    }
}
