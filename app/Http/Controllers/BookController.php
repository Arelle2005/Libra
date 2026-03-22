<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Afficher la liste des livres
     * 
     * Utilise les Scopes Eloquent pour la recherche et le filtrage
     * Inclut la pagination
     */
    public function index(Request $request)
    {
        // Commencer la requête Eloquent
        $query = Book::query();
        
        // Appliquer le scope de recherche si un terme est fourni
        if ($request->has('q') && $request->q != '') {
            $query->search($request->q);
        }
        
        // Appliquer le filtre de disponibilité si demandé
        if ($request->has('available') && $request->available == 1) {
            $query->available();
        }
        
        // Récupérer les résultats avec pagination (10 par page)
        $books = $query->latest()->paginate(10);
        
        return view('books.index', compact('books'));
    }

    /**
     * Afficher le formulaire de création d'un livre
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Enregistrer un nouveau livre en base de données
     * 
     * Utilise la validation et Mass Assignment
     */
    public function store(Request $request)
    {
        // === VALIDATION DES DONNÉES ===
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'author' => 'required|string|max:100',
            'isbn' => 'required|string|max:13|unique:books,isbn',
            'total_copies' => 'required|integer|min:1',
            'published_date' => 'nullable|date',
            'description' => 'nullable|string',
        ], [
            // Messages d'erreur personnalisés
            'title.required' => 'Le titre du livre est obligatoire.',
            'author.required' => 'L\'auteur est obligatoire.',
            'isbn.required' => 'L\'ISBN est obligatoire.',
            'isbn.unique' => 'Cet ISBN existe déjà dans la base.',
            'total_copies.min' => 'Le nombre d\'exemplaires doit être au moins 1.',
        ]);
        
        // === CRÉATION DU LIVRE (ORM: create) ===
        $book = Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'],
            'total_copies' => $validated['total_copies'],
            'available_copies' => $validated['total_copies'], // Même valeur au départ
            'published_date' => $validated['published_date'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);
        
        // === REDIRECTION AVEC MESSAGE FLASH ===
        return redirect()->route('books.index')
            ->with('success', "Le livre '{$book->title}' a été ajouté avec succès.");
    }

    /**
     * Afficher les détails d'un livre
     */
    public function show(Book $book)
    {
        // Eager Loading : charger les emprunts associés
        $book->load(['borrows.borrower']);
        
        return view('books.show', compact('book'));
    }

    /**
     * Afficher le formulaire de modification d'un livre
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Mettre à jour un livre en base de données
     * 
     * Utilise ORM: update()
     */
    public function update(Request $request, Book $book)
    {
        // === VALIDATION ===
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'author' => 'required|string|max:100',
            'isbn' => 'required|string|max:13|unique:books,isbn,' . $book->id,
            'total_copies' => 'required|integer|min:1',
            'published_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);
        
        // === MISE À JOUR (ORM: update) ===
        $book->update([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'],
            'total_copies' => $validated['total_copies'],
            'published_date' => $validated['published_date'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);
        
        // === REDIRECTION ===
        return redirect()->route('books.index')
            ->with('success', "Le livre '{$book->title}' a été mis à jour.");
    }

    /**
     * Supprimer un livre de la base de données
     * 
     * Utilise ORM: delete()
     */
    public function destroy(Book $book)
    {
        $title = $book->title;
        
        // Supprimer le livre (la FK restrict empêchera si des emprunts existent)
        $book->delete();
        
        return redirect()->route('books.index')
            ->with('success', "Le livre '{$title}' a été supprimé.");
    }
}