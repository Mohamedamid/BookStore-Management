<?php

namespace App\Http\Controllers;

use App\Models\Fourniture;
use Illuminate\Http\Request;

class FournitureController extends Controller
{
    public function index()
    {
        $userr = auth()->user();
        $fullName = $userr->name; // مثال: "Mohamed Amine"
        $firstName = explode(' ', $fullName)[0];
        $fournitures = Fourniture::orderBy('quantity', 'asc')->get();
        return view('outil', compact('fournitures' , 'firstName'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        Fourniture::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return redirect()->route('fournitures.index')->with('status', 'Fourniture ajoutée avec succès');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $fourniture = Fourniture::findOrFail($id);
        $fourniture->update([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return redirect()->route('fournitures.index')->with('status', 'Fourniture mise à jour avec succès');
    }

    public function destroy($id)
    {
        $fourniture = Fourniture::findOrFail($id);
        $fourniture->delete();

        return redirect()->route('fournitures.index')->with('status', 'Fourniture supprimée avec succès');
    }
}
