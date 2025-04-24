<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Fourniture;
use App\Models\User;
// use App\Models\Commande;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $userr = auth()->user();
        $fullName = $userr->name;
        $firstName = explode(' ', $fullName)[0];

        $TotalUser = User::count();

        $booksUnder50 = Book::where('quantity', '<', 50)->get();
        $fournituresUnder50 = Fourniture::where('quantity', '<', 50)->get();
        $TotalLivre = $booksUnder50->count();
        $TotalFourniture = $fournituresUnder50->count();

        $aujourdhui = Carbon::today();

        $commandesAujourdHui = Commande::whereDate('created_at', $aujourdhui)->count();
        $totalCommandes = Commande::count();

        $totalPriceCommandes = Commande::sum('total');
        $totalPriceCommandesAujourdHui = Commande::whereDate('created_at', $aujourdhui)->sum('total');

        $totalClients = Client::count();

        return view('home', compact(
            'TotalUser',
            'TotalLivre',
            'TotalFourniture',
            'booksUnder50',
            'fournituresUnder50',
            'firstName',
            'commandesAujourdHui',
            'totalCommandes',
            'totalPriceCommandes',
            'totalPriceCommandesAujourdHui',
            'totalClients'
        ));
    }
}
