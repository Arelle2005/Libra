<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Borrow;

// Tester le modèle Borrow
$borrow = Borrow::withRelations()->first();
if ($borrow) {
    echo "Emprunt #{$borrow->id}\n";
    echo "Livre : " . $borrow->book->title . "\n";
    echo "Emprunteur : " . $borrow->borrower->name . "\n";
    echo "Date d'emprunt : " . $borrow->formattedBorrowedDate . "\n";
    echo "Date de retour : " . $borrow->formattedDueDate . "\n";
    echo "Statut : " . $borrow->statusBadge['label'] . "\n";
    echo "En retard : " . ($borrow->isOverdue() ? 'Oui (' . $borrow->daysOverdue() . ' jours)' : 'Non') . "\n";
} else {
    echo "Aucun emprunt trouvé. Ajoute-en un dans phpMyAdmin pour tester.\n";
}