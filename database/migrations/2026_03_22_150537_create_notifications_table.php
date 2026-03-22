<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Relation polymorphique
            $table->string('notifiable_type', 191); // 191 pour éviter l'erreur MySQL
            $table->unsignedBigInteger('notifiable_id');
            
            $table->string('type', 191);
            $table->text('message');
            $table->json('data')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            // Index pour les requêtes
            $table->index(['notifiable_type', 'notifiable_id']);
            $table->index('read_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};