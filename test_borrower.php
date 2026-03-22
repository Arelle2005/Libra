<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Borrower;

// Tester le modèle Borrower
$borrower = Borrower::first();
if ($borrower) {
    echo "Emprunteur : " . $borrower->formattedName . "\n";
    echo "Matricule : " . $borrower->matricule . "\n";
    echo "Type : " . $borrower->typeBadge['label'] . "\n";
    echo "Emprunts actifs : " . $borrower->activeBorrows()->count() . "\n";
    echo "Peut emprunter : " . ($borrower->canBorrow() ? 'Oui' : 'Non') . "\n";
} else {
    echo "Aucun emprunteur trouvé. Ajoute-en un dans phpMyAdmin pour tester.\n";
}