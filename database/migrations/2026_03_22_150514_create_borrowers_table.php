<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('matricule', 50)->unique();
            $table->string('email', 191)->unique(); // 191 pour éviter l'erreur MySQL
            $table->string('phone', 15)->nullable();
            $table->enum('type', ['student', 'teacher', 'staff'])->default('student');
            $table->timestamps();
            
            // Index pour la recherche
            $table->index(['matricule', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowers');
    }
};