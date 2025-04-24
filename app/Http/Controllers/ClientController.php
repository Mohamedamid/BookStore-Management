<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{

    public function index()
    {
        $userr = Auth::user();
        $fullName = $userr->name;
        $firstName = explode(' ', $fullName)[0];
        $clientss = Client::all();
        return view('client', compact('clientss' , 'firstName'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'telephone' => 'required|string|max:20',
            'ville' => 'required|string|max:100',
            'adresse' => 'required|string|max:255',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')
            ->with('status', 'Client ajouté avec succès.')
            ->with('status_type', 'success');
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'telephone' => 'required|string|max:20',
            'ville' => 'required|string|max:100',
            'adresse' => 'required|string|max:255',
        ]);

        $client->update($request->all());

        return redirect()->route('clients.index')
            ->with('status', 'Client modifié avec succès.')
            ->with('status_type', 'success');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('status', 'Client supprimé avec succès.')
            ->with('status_type', 'success');
    }


    public function info($id)
    {
        $client = Client::findOrFail($id);
        return response()->json($client);
    }


}
