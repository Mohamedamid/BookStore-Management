<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Fourniture;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $TotalUser = User::count();
        $booksUnder50 = Book::where('quantity', '<', 50)->get();
        $fournituresUnder50 = Fourniture::where('quantity', '<', 50)->get();

        $TotalLivre = $booksUnder50->count();
        $TotalFourniture = $fournituresUnder50->count();

        return view('home', compact('TotalUser','TotalLivre','TotalFourniture','booksUnder50','fournituresUnder50'));
    }

}
