<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Book;
use App\Models\Borrower;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    /**
     * Afficher la liste des emprunts
     */
    public function index(Request $request)
    {
        $query = Borrow::with(['book', 'borrower', 'librarian']);
        
        // Filtre par statut
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filtre par emprunteur
        if ($request->has('borrower_id') && $request->borrower_id != '') {
            $query->where('borrower_id', $request->borrower_id);
        }
        
        $borrows = $query->latest('borrowed_at')->paginate(10);
        
        // Récupérer la liste des emprunteurs pour le filtre
        $borrowers = Borrower::all();
        
        return view('borrows.index', compact('borrows', 'borrowers'));
    }

    /**
     * Afficher le formulaire de création d'emprunt
     */
    public function create()
    {
        // Récupérer tous les livres disponibles et emprunteurs
        $books = Book::where('available_copies', '>', 0)->get();
        $borrowers = Borrower::all();
        
        return view('borrows.create', compact('books', 'borrowers'));
    }

    /**
     * Enregistrer un nouvel emprunt
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrower_id' => 'required|exists:borrowers,id',
            'duration' => 'required|integer|min:1|max:30',
        ], [
            'book_id.required' => 'Veuillez sélectionner un livre.',
            'borrower_id.required' => 'Veuillez sélectionner un emprunteur.',
            'duration.min' => 'La durée doit être d\'au moins 1 jour.',
            'duration.max' => 'La durée maximale est de 30 jours.',
        ]);
        
        // Vérifier la disponibilité du livre
        $book = Book::find($validated['book_id']);
        if ($book->available_copies <= 0) {
            return back()->withErrors(['book_id' => 'Ce livre n\'est pas disponible.']);
        }
        
        // Créer l'emprunt
        $borrow = Borrow::create([
            'book_id' => $validated['book_id'],
            'borrower_id' => $validated['borrower_id'],
            'librarian_id' => auth()->id(),
            'due_date' => now()->addDays($validated['duration']),
            'status' => 'active',
        ]);
        
        // Décrémenter le stock du livre
        $book->decrementStock();
        
        return redirect()->route('borrows.index')
            ->with('success', "Emprunt enregistré pour '{$book->title}'.");
    }

    /**
     * Afficher les détails d'un emprunt
     */
    public function show(Borrow $borrow)
    {
        $borrow->load(['book', 'borrower', 'librarian', 'notification']);
        return view('borrows.show', compact('borrow'));
    }

    /**
     * Marquer un emprunt comme retourné
     */
    public function markAsReturned(Borrow $borrow)
    {
        $borrow->markAsReturned();
        
        return redirect()->route('borrows.index')
            ->with('success', "Le livre '{$borrow->book->title}' a été retourné.");
    }

    /**
     * Supprimer un emprunt (seulement si pas encore retourné)
     */
    public function destroy(Borrow $borrow)
    {
        if ($borrow->status === 'returned') {
            return back()->withErrors(['error' => 'Impossible de supprimer un emprunt déjà retourné.']);
        }
        
        // Réincrémenter le stock si l'emprunt était actif
        if ($borrow->book) {
            $borrow->book->incrementStock();
        }
        
        $borrow->delete();
        
        return redirect()->route('borrows.index')
            ->with('success', "L'emprunt a été supprimé.");
    }
}