<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    /**
     * Afficher le formulaire d'inscription étudiant
     */
    public function showRegister()
    {
        return view('student.auth.register');
    }

    /**
     * Enregistrer un nouvel étudiant
     */
    public function register(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'matricule' => 'required|string|max:50|unique:borrowers,matricule',
            'email' => 'required|email|max:191|unique:borrowers,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:15',
            'type' => 'required|in:student,teacher,staff',
        ], [
            'matricule.unique' => 'Ce matricule est déjà utilisé.',
            'email.unique' => 'Cet email est déjà enregistré.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        // Création de l'emprunteur
        $borrower = Borrower::create([
            'name' => $validated['name'],
            'matricule' => $validated['matricule'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'type' => $validated['type'],
        ]);

        // Connexion automatique après inscription
        Auth::guard('borrower')->login($borrower);

        return redirect()->route('student.catalogue')
            ->with('success', 'Compte créé avec succès !');
    }

    /**
     * Afficher le formulaire de connexion étudiant
     */
    public function showLogin()
    {
        return view('student.auth.login');
    }

    /**
     * Connecter un étudiant
     */
    public function login(Request $request)
    {
        // Validation
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tentative de connexion avec le guard 'borrower'
        if (Auth::guard('borrower')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('student.catalogue'))
                ->with('success', 'Connexion réussie !');
        }

        // Échec de connexion
        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }

    /**
     * Déconnecter un étudiant
     */
    public function logout(Request $request)
    {
        Auth::guard('borrower')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.login')
            ->with('success', 'Déconnexion réussie !');
    }

    /**
     * Afficher le catalogue des livres (dashboard étudiant)
     */
    public function catalogue(Request $request)
    {
        // Récupérer tous les livres avec recherche
        $query = Book::query();
        
        // Recherche par titre, auteur ou ISBN
        if ($request->has('q') && $request->q != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'LIKE', "%{$request->q}%")
                  ->orWhere('author', 'LIKE', "%{$request->q}%")
                  ->orWhere('isbn', 'LIKE', "%{$request->q}%");
            });
        }
        
        $books = $query->paginate(12);
        
        // Récupérer l'emprunteur connecté
        $borrower = Auth::guard('borrower')->user();
        
        return view('student.catalogue', compact('books', 'borrower'));
    }
}