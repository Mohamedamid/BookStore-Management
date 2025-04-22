<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Book;
use App\Models\CommandeItem;
use App\Models\Fourniture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduitController extends Controller
{
    public function create()
    {
        $clients = Client::all();
        $userr = auth()->user();
        $fullName = $userr->name;
        $firstName = explode(' ', $fullName)[0];
        return view('Commande', compact('clients', 'firstName'));
    }

    public function findProduct($reference)
    {
        $product = Book::where('reference', $reference)->first();

        if (!$product) {
            $product = Fourniture::where('reference', $reference)->first();

            if (!$product) {
                return response()->json(['error' => 'Produit non trouvé'], 404);
            }
        }

        return response()->json([
            'reference' => $product->reference,
            'name' => $product->title ?? $product->name,
            'price' => $product->price
        ]);
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
            $commande = CommandeItem::create([
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

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'client_id' => 'required|exists:clients,id',
    //         'items' => 'required|array',
    //         'items.*.reference' => 'required',
    //         'items.*.name' => 'required',
    //         'items.*.quantity' => 'required|integer|min:1',
    //         'items.*.price' => 'required|numeric|min:0',
    //         'items.*.discount' => 'required|integer|min:0|max:100',
    //         'total_amount' => 'required|numeric|min:0'
    //     ]);

    //     // Ici vous pouvez implémenter la logique d'enregistrement
    //     // Exemple:
    //     // $vente = Vente::create([...]);
    //     // foreach($validated['items'] as $item) { VenteItem::create([...]); }

    //     return response()->json(['success' => true, 'message' => 'Vente enregistrée']);
    // }
}