<?php

namespace App\Http\Controllers;

use App\Models\Book;
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
    $fullName = $userr->name; // Ex: "Mohamed Amine"
    $firstName = explode(' ', $fullName)[0];

    // Totaux des utilisateurs
    $TotalUser = User::count();

    // Livres et fournitures < 50
    $booksUnder50 = Book::where('quantity', '<', 50)->get();
    $fournituresUnder50 = Fourniture::where('quantity', '<', 50)->get();
    $TotalLivre = $booksUnder50->count();
    $TotalFourniture = $fournituresUnder50->count();

    // // Total des commandes (toutes)
    // $totalOrders = Commande::count();

    // // Total des commandes d’aujourd’hui
    // $todayOrders = Commande::whereDate('created_at', Carbon::today())->count();

    return view('home', compact(
        'TotalUser',
        'TotalLivre',
        'TotalFourniture',
        'booksUnder50',
        'fournituresUnder50',
        'firstName',
        // 'totalOrders',
        // 'todayOrders'
    ));
}

}
