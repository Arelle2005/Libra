<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;

class Notification extends Model
{
    /**
     * Indique que la clé primaire n'est pas auto-incrémentée
     * (On utilise des UUID pour les notifications)
     */
    public $incrementing = false;

    /**
     * Le type de la clé primaire
     */
    protected $keyType = 'string';

    /**
     * Les attributs qui peuvent être remplis en masse (Mass Assignment)
     */
    protected $fillable = [
        'id',
        'notifiable_type',
        'notifiable_id',
        'type',
        'message',
        'data',
        'read_at',
    ];

    /**
     * Les attributs qui doivent être castés vers des types natifs
     */
    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * =====================================================================
     * BOOT METHOD : Initialisation automatique
     * =====================================================================
     */

    /**
     * Générer automatiquement un UUID lors de la création
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * =====================================================================
     * RELATIONS POLYMORPHIQUES - morphTo / morphToMany
     * =====================================================================
     */

    /**
     * La notification peut appartenir à plusieurs types de modèles
     * morphTo : Notification ---- (?) Book | Borrower | Borrow | User
     * 
     * C'est la relation polymorphique PRINCIPALE qui permet à une notification
     * d'être attachée à n'importe quel modèle du système.
     * 
     * Exemple d'utilisation : 
     * - $notification->notifiable (retourne le modèle associé : Book, Borrow, etc.)
     * - $notification->notifiable->title (si c'est un Book)
     * - $notification->notifiable->name (si c'est un Borrower)
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Une notification peut être liée à plusieurs tags (Relation: MorphToMany)
     * morphToMany : Notification (M) ---- (M) Tag (via table pivot 'taggables')
     * 
     * Cette relation permet de catégoriser les notifications par tags
     * (ex: 'retard', 'nouveau_livre', 'rappel', 'urgent')
     * 
     * Exemple d'utilisation : $notification->tags
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * =====================================================================
     * RELATIONS INVERSES - morphedByMany (Définies dans le modèle Tag)
     * =====================================================================
     * 
     * NOTE : La relation morphedByMany se définit dans le modèle Tag, pas ici.
     * C'est l'inverse de morphToMany.
     * 
     * Dans le modèle Tag, on aurait :
     * 
     * public function notifications(): MorphToMany
     * {
     *     return $this->morphedByMany(Notification::class, 'taggable');
     * }
     * 
     * Exemple d'utilisation (depuis Tag) : 
     * - $tag->notifications (toutes les notifications avec ce tag)
     */

    /**
     * =====================================================================
     * SCOPES POUR LES REQUÊTES (Query Scopes)
     * =====================================================================
     */

    /**
     * Scope : Filtrer uniquement les notifications non lues
     * Exemple d'utilisation : Notification::unread()->get()
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope : Filtrer uniquement les notifications lues
     * Exemple d'utilisation : Notification::read()->get()
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope : Filtrer par type de notification
     * Exemple d'utilisation : Notification::byType('overdue_alert')->get()
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope : Filtrer par modèle notifiable (Book, Borrow, Borrower, etc.)
     * Exemple d'utilisation : Notification::forType(Borrow::class)->get()
     */
    public function scopeForType($query, $notifiableType)
    {
        return $query->where('notifiable_type', $notifiableType);
    }

    /**
     * Scope : Notifications d'urgence uniquement
     * Exemple d'utilisation : Notification::urgent()->get()
     */
    public function scopeUrgent($query)
    {
        return $query->where('type', 'overdue_alert')
                    ->orWhere('type', 'critical');
    }

    /**
     * =====================================================================
     * MÉTHODES UTILITAIRES
     * =====================================================================
     */

    /**
     * Vérifier si la notification est non lue
     * Exemple d'utilisation : $notification->isUnread()
     */
    public function isUnread(): bool
    {
        return $this->read_at === null;
    }

    /**
     * Vérifier si la notification est lue
     * Exemple d'utilisation : $notification->isRead()
     */
    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    /**
     * Marquer la notification comme lue
     * Exemple d'utilisation : $notification->markAsRead()
     */
    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }

    /**
     * Marquer la notification comme non lue
     * Exemple d'utilisation : $notification->markAsUnread()
     */
    public function markAsUnread(): void
    {
        $this->update(['read_at' => null]);
    }

    /**
     * Obtenir une icône FontAwesome selon le type de notification
     * Exemple d'utilisation : $notification->icon
     */
    public function getIconAttribute(): string
    {
        $icons = [
            'overdue_alert' => 'fa-exclamation-triangle',
            'return_reminder' => 'fa-clock',
            'new_book' => 'fa-book',
            'welcome' => 'fa-hand-wave',
            'critical' => 'fa-bell',
        ];
        return $icons[$this->type] ?? 'fa-info-circle';
    }

    /**
     * Obtenir une couleur selon le type de notification
     * Exemple d'utilisation : $notification->colorClass
     */
    public function getColorClassAttribute(): string
    {
        $colors = [
            'overdue_alert' => 'bg-rose-100 text-rose-700 border-rose-300',
            'return_reminder' => 'bg-amber-100 text-amber-700 border-amber-300',
            'new_book' => 'bg-emerald-100 text-emerald-700 border-emerald-300',
            'welcome' => 'bg-blue-100 text-blue-700 border-blue-300',
            'critical' => 'bg-purple-100 text-purple-700 border-purple-300',
        ];
        return $colors[$this->type] ?? 'bg-gray-100 text-gray-700 border-gray-300';
    }

    /**
     * Obtenir le message formaté avec les données dynamiques
     * Exemple d'utilisation : $notification->formattedMessage
     */
    public function getFormattedMessageAttribute(): string
    {
        $message = $this->message;
        
        // Remplacer les placeholders par les données réelles
        if ($this->data) {
            foreach ($this->data as $key => $value) {
                $message = str_replace('{' . $key . '}', $value, $message);
            }
        }
        
        return $message;
    }

    /**
     * =====================================================================
     * MÉTHODES STATIQUES POUR LA CRÉATION DE NOTIFICATIONS
     * =====================================================================
     */

    /**
     * Créer une notification de retard d'emprunt
     * Exemple d'utilisation : Notification::createOverdue($borrow)
     */
    public static function createOverdue(Borrow $borrow, string $customMessage = null): self
    {
        $notification = new static([
            'type' => 'overdue_alert',
            'message' => $customMessage ?? "L'emprunt de '{$borrow->book->title}' est en retard depuis {$borrow->daysOverdue()} jour(s).",
            'data' => [
                'borrow_id' => $borrow->id,
                'book_title' => $borrow->book->title ?? '',
                'borrower_name' => $borrow->borrower->name ?? '',
                'due_date' => $borrow->due_date->format('d/m/Y'),
                'days_overdue' => $borrow->daysOverdue(),
            ],
        ]);

        $borrow->notification()->save($notification);
        return $notification;
    }

    /**
     * Créer une notification de rappel de retour
     * Exemple d'utilisation : Notification::createReturnReminder($borrow)
     */
    public static function createReturnReminder(Borrow $borrow): self
    {
        $notification = new static([
            'type' => 'return_reminder',
            'message' => "Rappel : Le livre '{$borrow->book->title}' doit être retourné le {$borrow->due_date->format('d/m/Y')}.",
            'data' => [
                'borrow_id' => $borrow->id,
                'book_title' => $borrow->book->title ?? '',
                'due_date' => $borrow->due_date->format('d/m/Y'),
            ],
        ]);

        $borrow->notification()->save($notification);
        return $notification;
    }

    /**
     * Créer une notification de nouveau livre disponible
     * Exemple d'utilisation : Notification::createNewBook($book)
     */
    public static function createNewBook(Book $book): self
    {
        $notification = new static([
            'type' => 'new_book',
            'message' => "Nouveau livre disponible : '{$book->title}' par {$book->author}.",
            'data' => [
                'book_id' => $book->id,
                'book_title' => $book->title,
                'author' => $book->author,
            ],
        ]);

        $book->notification()->save($notification);
        return $notification;
    }

    /**
     * =====================================================================
     * EAGER LOADING HELPERS (Pour éviter le problème N+1)
     * =====================================================================
     */

    /**
     * Charger les notifications avec le modèle notifiable en une seule requête
     * Exemple d'utilisation : Notification::withNotifiable()->get()
     */
    public function scopeWithNotifiable($query)
    {
        return $query->with('notifiable');
    }

    /**
     * Charger les notifications avec les tags en une seule requête
     * Exemple d'utilisation : Notification::withTags()->get()
     */
    public function scopeWithTags($query)
    {
        return $query->with('tags');
    }
}