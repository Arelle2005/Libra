<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\StudentAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes - Application Libra
|--------------------------------------------------------------------------
|
| Ce fichier contient toutes les routes de l'application.
| Les routes sont organisées par type d'utilisateur et niveau d'accès.
|
*/

// ============================================================================
// ROUTES PUBLIQUES (Sans authentification)
// ============================================================================

// Page d'accueil → Redirige vers login étudiant par défaut
Route::get('/', function () {
    return redirect()->route('student.login');
})->name('home');

// Routes étudiant publiques (inscription/connexion)
Route::get('/student/login', [StudentAuthController::class, 'showLogin'])->name('student.login');
Route::post('/student/login', [StudentAuthController::class, 'login'])->name('student.login.post');
Route::get('/student/register', [StudentAuthController::class, 'showRegister'])->name('student.register');
Route::post('/student/register', [StudentAuthController::class, 'register'])->name('student.register.post');

// ============================================================================
// ROUTES BIBLIOTHÉCAIRE (Laravel Breeze)
// ============================================================================
// Note: Les routes d'inscription (/register) sont désactivées pour les bibliothécaires.
// Seuls les comptes bibliothécaires ajoutés manuellement en base de données peuvent se connecter.

require __DIR__.'/auth.php';

// ============================================================================
// ROUTES PROTÉGÉES - ÉTUDIANT (Guard: auth:borrower)
// ============================================================================

Route::middleware(['auth:borrower'])->prefix('student')->name('student.')->group(function () {
    
    // Catalogue étudiant (dashboard étudiant)
    Route::get('/catalogue', [StudentAuthController::class, 'catalogue'])->name('catalogue');
    
    // Déconnexion étudiant
    Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout');
    
});

// ============================================================================
// ROUTES PROTÉGÉES - BIBLIOTHÉCAIRE (Guard: auth:web)
// ============================================================================

Route::middleware(['auth:web'])->group(function () {
    
    // Tableau de bord bibliothécaire
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des livres (CRUD complet)
    Route::resource('books', BookController::class);
    
    // Gestion des emprunteurs (CRUD complet)
    Route::resource('borrowers', BorrowerController::class);
    
    // Gestion des emprunts (CRUD + action retour)
    Route::resource('borrows', BorrowController::class);
    Route::patch('borrows/{borrow}/return', [BorrowController::class, 'markAsReturned'])
         ->name('borrows.return');
    
    // Gestion du profil bibliothécaire (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});