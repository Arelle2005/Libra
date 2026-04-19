<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ajoute les champs nécessaires pour l'authentification des emprunteurs
     */
    public function up(): void
    {
        Schema::table('borrowers', function (Blueprint $table) {
            // Champ password pour l'authentification (après email)
            $table->string('password')->after('email');
            
            // Champ remember_token pour la fonctionnalité "Se souvenir de moi" (optionnel mais recommandé)
            $table->rememberToken()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     * Supprime les champs ajoutés si on rollback la migration
     */
    public function down(): void
    {
        Schema::table('borrowers', function (Blueprint $table) {
            // Supprimer remember_token d'abord (dépendance)
            $table->dropColumn('remember_token');
            
            // Supprimer password ensuite
            $table->dropColumn('password');
        });
    }
};