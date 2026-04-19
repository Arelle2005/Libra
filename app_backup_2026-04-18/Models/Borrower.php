<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Borrower extends Model
{
    /**
     * Les attributs qui peuvent être remplis en masse (Mass Assignment)
     */
    protected $fillable = [
        'name',
        'matricule',
        'email',
        'phone',
        'type', // student, teacher, staff
    ];

    /**
     * Les attributs qui doivent être castés vers des types natifs
     */
    protected $casts = [
        'type' => 'string',
    ];

    /**
     * =====================================================================
     * RELATIONS STANDARDS (Eloquent ORM)
     * =====================================================================
     */

    /**
     * Un emprunteur peut avoir plusieurs emprunts (Relation: One-to-Many)
     * hasMany : Borrower (1) ---- (M) Borrow
     */
    public function borrows(): HasMany
    {
        return $this->hasMany(Borrow::class);
    }

    /**
     * Un emprunteur peut avoir plusieurs notifications polymorphiques
     * morphMany : Borrower (1) ---- (M) Notification (en tant que notifiable)
     * 
     * Cette relation permet d'envoyer des alertes spécifiques à un emprunteur
     * (ex: retard de retour, nouveau livre disponible, etc.)
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
     * Exemple d'utilisation : $borrower->activeBorrows
     */
    public function activeBorrows(): HasMany
    {
        return $this->borrows()->where('status', 'active');
    }

    /**
     * Relation : Emprunts en retard uniquement
     * Exemple d'utilisation : $borrower->overdueBorrows
     */
    public function overdueBorrows(): HasMany
    {
        return $this->borrows()
            ->where('status', 'active')
            ->where('due_date', '<', now());
    }

    /**
     * Charger les emprunts avec les informations du livre (Eager Loading helper)
     * Évite le problème N+1 queries
     * Exemple d'utilisation : $borrower->borrowsWithBook()
     */
    public function borrowsWithBook()
    {
        return $this->borrows()->with('book')->get();
    }

    /**
     * =====================================================================
     * SCOPES POUR LES REQUÊTES (Query Scopes)
     * =====================================================================
     */

    /**
     * Scope : Recherche multicritère (nom, matricule, email)
     * Exemple d'utilisation : Borrower::search('Jean')->get()
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('name', 'LIKE', "%{$keyword}%")
              ->orWhere('matricule', 'LIKE', "%{$keyword}%")
              ->orWhere('email', 'LIKE', "%{$keyword}%");
        });
    }

    /**
     * Scope : Filtrer par type d'emprunteur (student, teacher, staff)
     * Exemple d'utilisation : Borrower::byType('teacher')->get()
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope : Filtrer uniquement les étudiants
     * Exemple d'utilisation : Borrower::students()->get()
     */
    public function scopeStudents($query)
    {
        return $query->where('type', 'student');
    }

    /**
     * Scope : Filtrer uniquement les enseignants
     * Exemple d'utilisation : Borrower::teachers()->get()
     */
    public function scopeTeachers($query)
    {
        return $query->where('type', 'teacher');
    }

    /**
     * =====================================================================
     * MÉTHODES UTILITAIRES
     * =====================================================================
     */

    /**
     * Vérifier si l'emprunteur a des emprunts en cours
     * Exemple d'utilisation : $borrower->hasActiveBorrows()
     */
    public function hasActiveBorrows(): bool
    {
        return $this->borrows()->where('status', 'active')->exists();
    }

    /**
     * Compter le nombre d'emprunts en retard
     * Exemple d'utilisation : $borrower->countOverdue()
     */
    public function countOverdue(): int
    {
        return $this->borrows()
            ->where('status', 'active')
            ->where('due_date', '<', now())
            ->count();
    }

    /**
     * Formatage du nom complet pour l'affichage
     * Exemple d'utilisation : $borrower->formattedName
     */
    public function getFormattedNameAttribute(): string
    {
        return ucwords(strtolower($this->name));
    }

    /**
     * Générer un badge de type pour l'interface (student/teacher/staff)
     * Exemple d'utilisation : $borrower->typeBadge
     */
    public function getTypeBadgeAttribute(): array
    {
        $badges = [
            'student' => ['class' => 'bg-blue-100 text-blue-700', 'label' => 'Étudiant'],
            'teacher' => ['class' => 'bg-purple-100 text-purple-700', 'label' => 'Enseignant'],
            'staff' => ['class' => 'bg-gray-100 text-gray-700', 'label' => 'Personnel'],
        ];
        return $badges[$this->type] ?? $badges['student'];
    }

    /**
     * Vérifier si l'emprunteur peut emprunter un nouveau livre
     * (Règle métier : max 3 livres simultanés pour les étudiants)
     * Exemple d'utilisation : $borrower->canBorrow()
     */
    public function canBorrow(int $limit = 3): bool
    {
        if ($this->type === 'student') {
            return $this->activeBorrows()->count() < $limit;
        }
        // Enseignants et personnel : pas de limite stricte
        return true;
    }
}