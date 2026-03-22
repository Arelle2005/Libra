<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            
            // Clés étrangères
            $table->foreignId('book_id')->constrained('books')->onDelete('restrict');
            $table->foreignId('borrower_id')->constrained('borrowers')->onDelete('cascade');
            $table->foreignId('librarian_id')->constrained('users')->onDelete('restrict');
            
            // Dates et statut
            $table->timestamp('borrowed_at')->useCurrent();
            $table->timestamp('due_date');
            $table->timestamp('returned_at')->nullable();
            $table->enum('status', ['active', 'returned', 'overdue'])->default('active');
            
            // Notes optionnelles
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Index pour les requêtes fréquentes
            $table->index(['status', 'due_date']);
            $table->index(['borrower_id', 'returned_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};