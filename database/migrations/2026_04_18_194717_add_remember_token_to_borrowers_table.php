<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowers', function (Blueprint $table) {
            // Ajouter remember_token s'il n'existe pas déjà
            if (!Schema::hasColumn('borrowers', 'remember_token')) {
                $table->rememberToken()->after('password');
            }
        });
    }

    public function down(): void
    {
        Schema::table('borrowers', function (Blueprint $table) {
            $table->dropColumn('remember_token');
        });
    }
};