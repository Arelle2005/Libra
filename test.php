<?php
require __DIR__.'/vendor/autoload.php';

$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;

// Tester le modèle Book
$book = Book::first();
if ($book) {
    echo "Livre trouvé : " . $book->title . "\n";
    echo "Disponible : " . ($book->isAvailable() ? 'Oui' : 'Non') . "\n";
    echo "Nombre d'emprunts : " . $book->borrows->count() . "\n";
} else {
    echo "Aucun livre trouvé dans la base.\n";
}