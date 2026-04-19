<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Borrow extends Model
{
    /**
     * Les attributs qui peuvent être remplis en masse (Mass Assignment)
     */
    protected $fillable = [
        'book_id',
        'borrower_id',
        'librarian_id',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status', // active, returned, overdue
        'notes',
    ];

    /**
     * Les attributs qui doivent être castés vers des types natifs
     */
    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * =====================================================================
     * RELATIONS STANDARDS (Eloquent ORM) - belongsTo
     * =====================================================================
     */

    /**
     * Un emprunt appartient à un livre (Relation: Many-to-One)
     * belongsTo : Borrow (M) ---- (1) Book
     * 
     * Exemple d'utilisation : $borrow->book->title
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Un emprunt appartient à un emprunteur (Relation: Many-to-One)
     * belongsTo : Borrow (M) ---- (1) Borrower
     * 
     * Exemple d'utilisation : $borrow->borrower->name
     */
    public function borrower(): BelongsTo
    {
        return $this->belongsTo(Borrower::class);
    }

    /**
     * Un emprunt appartient à un bibliothécaire (Relation: Many-to-One)
     * belongsTo : Borrow (M) ---- (1) User (librarian)
     * 
     * Exemple d'utilisation : $borrow->librarian->name
     */
    public function librarian(): BelongsTo
    {
        return $this->belongsTo(User::class, 'librarian_id');
    }

    /**
     * =====================================================================
     * RELATIONS POLYMORPHIQUES - morphOne
     * =====================================================================
     */

    /**
     * Un emprunt peut avoir une notification polymorphique
     * morphOne : Borrow (1) ---- (1) Notification (en tant que notifiable)
     * 
     * Cette relation permet d'attacher des alertes spécifiques à un emprunt
     * (ex: notification de retard, rappel de retour, etc.)
     * 
     * Exemple d'utilisation : $borrow->notification->message
     */
    public function notification(): MorphOne
    {
        return $this->morphOne(Notification::class, 'notifiable');
    }

    /**
     * =====================================================================
     * RELATIONS AVANCÉES - hasOneThrough (Exemple pédagogique du rapport)
     * =====================================================================
     */

    /**
     * Relation hasOneThrough : Obtenir l'auteur du livre via l'emprunteur
     * 
     * Cette relation est un exemple avancé montrant comment traverser
     * plusieurs tables pour accéder à une donnée indirecte.
     * 
     * Schéma : Borrow -> Borrower -> (via une table intermédiaire hypothétique) -> Book -> Author
     * 
     * NOTE : Cette relation est principalement pédagogique. En pratique,
     * on accède directement à l'auteur via $borrow->book->author
     * 
     * Exemple d'utilisation (théorique) : $borrow->authorThroughBorrower
     */
    public function authorThroughBorrower(): HasOneThrough
    {
        return $this->hasOneThrough(
            Book::class,           // Modèle final à atteindre
            Borrower::class,       // Modèle intermédiaire
            'id',                  // Clé étrangère sur la table borrowers (local key)
            'id',                  // Clé étrangère sur la table books (foreign key)
            'borrower_id',        // Clé locale sur la table borrows
            'id'                  // Clé locale sur la table borrowers
        );
    }

    /**
     * =====================================================================
     * SCOPES POUR LES REQUÊTES (Query Scopes)
     * =====================================================================
     */

    /**
     * Scope : Filtrer uniquement les emprunts actifs
     * Exemple d'utilisation : Borrow::active()->get()
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope : Filtrer uniquement les emprunts en retard
     * Exemple d'utilisation : Borrow::overdue()->get()
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'active')
                    ->where('due_date', '<', now());
    }

    /**
     * Scope : Filtrer uniquement les emprunts retournés
     * Exemple d'utilisation : Borrow::returned()->get()
     */
    public function scopeReturned($query)
    {
        return $query->where('status', 'returned');
    }

    /**
     * Scope : Filtrer par emprunteur spécifique
     * Exemple d'utilisation : Borrow::byBorrower($id)->get()
     */
    public function scopeByBorrower($query, $borrowerId)
    {
        return $query->where('borrower_id', $borrowerId);
    }

    /**
     * Scope : Filtrer par livre spécifique
     * Exemple d'utilisation : Borrow::byBook($id)->get()
     */
    public function scopeByBook($query, $bookId)
    {
        return $query->where('book_id', $bookId);
    }

    /**
     * Scope : Emprunts à retourner bientôt (dans les 3 prochains jours)
     * Exemple d'utilisation : Borrow::dueSoon()->get()
     */
    public function scopeDueSoon($query, $days = 3)
    {
        return $query->where('status', 'active')
                    ->whereBetween('due_date', [now(), now()->addDays($days)]);
    }

    /**
     * =====================================================================
     * MÉTHODES UTILITAIRES
     * =====================================================================
     */

    /**
     * Vérifier si l'emprunt est en retard
     * Exemple d'utilisation : $borrow->isOverdue()
     */
    public function isOverdue(): bool
    {
        return $this->status === 'active' && $this->due_date->isPast();
    }

    /**
     * Calculer le nombre de jours de retard
     * Exemple d'utilisation : $borrow->daysOverdue()
     * Retourne 0 si pas de retard
     */
    public function daysOverdue(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        return now()->diffInDays($this->due_date, false);
    }

    /**
     * Calculer le nombre de jours restants avant l'échéance
     * Exemple d'utilisation : $borrow->daysRemaining()
     * Retourne un nombre négatif si en retard
     */
    public function daysRemaining(): int
    {
        return now()->diffInDays($this->due_date, true) * 
               ($this->due_date->isFuture() ? 1 : -1);
    }

    /**
     * Marquer l'emprunt comme retourné
     * Met à jour le statut, la date de retour, et incrémente le stock du livre
     * Exemple d'utilisation : $borrow->markAsReturned()
     */
    public function markAsReturned(): void
    {
        $this->update([
            'status' => 'returned',
            'returned_at' => now(),
        ]);

        // Incrémenter le stock du livre associé
        if ($this->book) {
            $this->book->incrementStock();
        }
    }

    /**
     * Créer une notification de retard pour cet emprunt
     * Exemple d'utilisation : $borrow->createOverdueNotification()
     */
    public function createOverdueNotification(string $message = null): void
    {
        $notification = new Notification([
            'id' => (string) \Str::uuid(),
            'type' => 'overdue_alert',
            'message' => $message ?? "L'emprunt de '{$this->book->title}' est en retard depuis {$this->daysOverdue()} jour(s).",
            'data' => [
                'borrow_id' => $this->id,
                'book_title' => $this->book->title ?? '',
                'borrower_name' => $this->borrower->name ?? '',
                'due_date' => $this->due_date->format('Y-m-d'),
            ],
        ]);

        $this->notification()->save($notification);
    }

    /**
     * Formatage de la date d'emprunt pour l'affichage
     * Exemple d'utilisation : $borrow->formattedBorrowedDate
     */
    public function getFormattedBorrowedDateAttribute(): string
    {
        return $this->borrowed_at->format('d/m/Y');
    }

    /**
     * Formatage de la date d'échéance pour l'affichage
     * Exemple d'utilisation : $borrow->formattedDueDate
     */
    public function getFormattedDueDateAttribute(): string
    {
        return $this->due_date->format('d/m/Y');
    }

    /**
     * Badge de statut pour l'interface (couleur + label)
     * Exemple d'utilisation : $borrow->statusBadge
     */
    public function getStatusBadgeAttribute(): array
    {
        $badges = [
            'active' => ['class' => 'bg-amber-100 text-amber-700', 'label' => 'En cours'],
            'returned' => ['class' => 'bg-emerald-100 text-emerald-700', 'label' => 'Rendu'],
            'overdue' => ['class' => 'bg-rose-100 text-rose-700', 'label' => 'En retard'],
        ];
        return $badges[$this->status] ?? $badges['active'];
    }

    /**
     * =====================================================================
     * EAGER LOADING HELPERS (Pour éviter le problème N+1)
     * =====================================================================
     */

    /**
     * Charger un emprunt avec le livre et l'emprunteur en une seule requête
     * Exemple d'utilisation : Borrow::withRelations()->get()
     */
    public function scopeWithRelations($query)
    {
        return $query->with(['book', 'borrower', 'librarian']);
    }
}