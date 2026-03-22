<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use Illuminate\Http\Request;

class BorrowerController extends Controller
{
    /**
     * Afficher la liste des emprunteurs
     */
    public function index(Request $request)
    {
        $query = Borrower::query();
        
        // Recherche multicritère
        if ($request->has('q') && $request->q != '') {
            $query->search($request->q);
        }
        
        // Filtre par type
        if ($request->has('type') && $request->type != '') {
            $query->byType($request->type);
        }
        
        $borrowers = $query->latest()->paginate(10);
        
        return view('borrowers.index', compact('borrowers'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('borrowers.create');
    }

    /**
     * Enregistrer un nouvel emprunteur
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'matricule' => 'required|string|max:50|unique:borrowers,matricule',
            'email' => 'required|email|max:191|unique:borrowers,email',
            'phone' => 'nullable|string|max:15',
            'type' => 'required|in:student,teacher,staff',
        ], [
            'matricule.unique' => 'Ce matricule existe déjà.',
            'email.unique' => 'Cet email est déjà enregistré.',
        ]);
        
        $borrower = Borrower::create($validated);
        
        return redirect()->route('borrowers.index')
            ->with('success', "L'emprunteur '{$borrower->name}' a été enregistré.");
    }

    /**
     * Afficher les détails d'un emprunteur
     */
    public function show(Borrower $borrower)
    {
        $borrower->load(['borrows.book']);
        return view('borrowers.show', compact('borrower'));
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit(Borrower $borrower)
    {
        return view('borrowers.edit', compact('borrower'));
    }

    /**
     * Mettre à jour un emprunteur
     */
    public function update(Request $request, Borrower $borrower)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'matricule' => 'required|string|max:50|unique:borrowers,matricule,' . $borrower->id,
            'email' => 'required|email|max:191|unique:borrowers,email,' . $borrower->id,
            'phone' => 'nullable|string|max:15',
            'type' => 'required|in:student,teacher,staff',
        ]);
        
        $borrower->update($validated);
        
        return redirect()->route('borrowers.index')
            ->with('success', "L'emprunteur '{$borrower->name}' a été mis à jour.");
    }

    /**
     * Supprimer un emprunteur
     */
    public function destroy(Borrower $borrower)
    {
        $name = $borrower->name;
        $borrower->delete();
        
        return redirect()->route('borrowers.index')
            ->with('success', "L'emprunteur '{$name}' a été supprimé.");
    }
}