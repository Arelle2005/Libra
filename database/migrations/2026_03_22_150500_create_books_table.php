<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('author', 100);
            $table->string('isbn', 13)->unique();
            $table->integer('total_copies')->default(1);
            $table->integer('available_copies')->default(1);
            $table->date('published_date')->nullable();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->timestamps();
            
            // Index pour la recherche
            $table->index(['title', 'author']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};