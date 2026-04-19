<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Book extends Model
{
    /**
     * Les attributs qui peuvent être remplis en masse (Mass Assignment)
     */
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'total_copies',
        'available_copies',
        'published_date',
        'description',
    ];

    /**
     * Les attributs qui doivent être castés vers des types natifs
     */
    protected $casts = [
        'published_date' => 'date',
        'total_copies' => 'integer',
        'available_copies' => 'integer',
    ];

    /**
     * =====================================================================
     * RELATIONS STANDARDS (Eloquent ORM)
     * =====================================================================
     */

    /**
     * Un livre peut avoir plusieurs emprunts (Relation: One-to-Many)
     * hasMany : Book (1) ---- (M) Borrow
     */
    public function borrows(): HasMany
    {
        return $this->hasMany(Borrow::class);
    }

    /**
     * Un livre peut avoir une notification polymorphique (Relation: MorphOne)
     * morphOne : Book (1) ---- (1) Notification (en tant que notifiable)
     */
    public function notification(): MorphOne
    {
        return $this->morphOne(Notification::class, 'notifiable');
    }

    /**
     * Un livre peut avoir plusieurs notifications (Relation: MorphMany)
     * morphMany : Book (1) ---- (M) Notification (en tant que notifiable)
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    /**
     * =====================================================================
     * RELATIONS AVEC SCOPES (Requêtes personnalisées)
     * =====================================================================
     */

    /**
     * Relation : Emprunts actifs uniquement (Scope + Relation)
     * Exemple d'utilisation : $book->activeBorrows
     */
    public function activeBorrows(): HasMany
    {
        return $this->borrows()->where('status', 'active');
    }

    /**
     * Charger les emprunts avec les informations de l'emprunteur (Eager Loading helper)
     * Exemple d'utilisation : $book->borrowsWithBorrower()
     * Évite le problème N+1 queries
     */
    public function borrowsWithBorrower()
    {
        return $this->borrows()->with('borrower')->get();
    }

    /**
     * =====================================================================
     * SCOPES POUR LES REQUÊTES (Query Scopes)
     * =====================================================================
     */

    /**
     * Scope : Filtrer uniquement les livres disponibles
     * Exemple d'utilisation : Book::available()->get()
     */
    public function scopeAvailable($query)
    {
        return $query->where('available_copies', '>', 0);
    }

    /**
     * Scope : Recherche multicritère (titre, auteur, ISBN)
     * Exemple d'utilisation : Book::search('Python')->get()
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('title', 'LIKE', "%{$keyword}%")
              ->orWhere('author', 'LIKE', "%{$keyword}%")
              ->orWhere('isbn', 'LIKE', "%{$keyword}%");
        });
    }

    /**
     * Scope : Filtrer par auteur
     * Exemple d'utilisation : Book::byAuthor('Matthes')->get()
     */
    public function scopeByAuthor($query, $author)
    {
        return $query->where('author', 'LIKE', "%{$author}%");
    }

    /**
     * =====================================================================
     * MÉTHODES UTILITAIRES
     * =====================================================================
     */

    /**
     * Vérifier si le livre est disponible à l'emprunt
     * Exemple d'utilisation : $book->isAvailable()
     */
    public function isAvailable(): bool
    {
        return $this->available_copies > 0;
    }

    /**
     * Décrémenter le stock disponible (lors d'un emprunt)
     * Exemple d'utilisation : $book->decrementStock()
     */
    public function decrementStock(): void
    {
        if ($this->available_copies > 0) {
            $this->decrement('available_copies');
        }
    }

    /**
     * Incrémenter le stock disponible (lors d'un retour)
     * Exemple d'utilisation : $book->incrementStock()
     */
    public function incrementStock(): void
    {
        if ($this->available_copies < $this->total_copies) {
            $this->increment('available_copies');
        }
    }

    /**
     * Formatage du titre pour l'affichage
     * Exemple d'utilisation : $book->formattedTitle
     */
    public function getFormattedTitleAttribute(): string
    {
        return ucwords(strtolower($this->title));
    }
}