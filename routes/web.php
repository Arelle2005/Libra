<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\BorrowController;

/*
|--------------------------------------------------------------------------
| Web Routes - Application Libra
|--------------------------------------------------------------------------
*/

// ============================================================================
// ROUTES PUBLIQUES
// ============================================================================

// Page d'accueil (redirige vers login si non authentifié)
Route::get('/', function () {
    return redirect()->route('login');
});

// ============================================================================
// ROUTES D'AUTHENTIFICATION (Laravel Breeze)
// ============================================================================

require __DIR__.'/auth.php';

// ============================================================================
// ROUTES PROTÉGÉES (Authentification requise)
// ============================================================================

Route::middleware(['auth'])->group(function () {
    
    // --- Tableau de bord personnalisé (remplace celui de Breeze) ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // --- Gestion des livres (CRUD complet) ---
    Route::resource('books', BookController::class);
    
    // --- Gestion des emprunteurs (CRUD complet) ---
    Route::resource('borrowers', BorrowerController::class);
    
    // --- Gestion des emprunts (CRUD + action retour) ---
    Route::resource('borrows', BorrowController::class);
    Route::patch('borrows/{borrow}/return', [BorrowController::class, 'markAsReturned'])
         ->name('borrows.return');
    
    // --- Gestion du profil utilisateur (Breeze) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});