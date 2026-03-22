<?php

namespace App\Http\Controllers;  // ⚠️ CRUCIAL : Ce namespace doit être exact

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Borrower;
use Illuminate\Http\Request;

class DashboardController extends Controller  // ⚠️ Le nom de la classe = nom du fichier
{
    /**
     * Afficher le tableau de bord avec statistiques
     */
    public function index()
    {
        // Statistiques globales (ORM Eloquent)
        $booksCount = Book::count();
        $borrowersCount = Borrower::count();
        $activeBorrows = Borrow::where('status', 'active')->count();
        $lateBorrows = Borrow::where('status', 'active')
                            ->where('due_date', '<', now())
                            ->count();
        
        // Emprunts récents avec Eager Loading (évite N+1)
        $recentBorrows = Borrow::with(['book', 'borrower'])
            ->latest('borrowed_at')
            ->limit(5)
            ->get();
        
        // Passer les données à la vue Blade
        return view('dashboard.index', compact(
            'booksCount',
            'borrowersCount',
            'activeBorrows',
            'lateBorrows',
            'recentBorrows'
        ));
    }
}