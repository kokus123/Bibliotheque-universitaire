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
            $table->string('titre');
            $table->string('auteur');
            $table->string('isbn')->unique()->nullable();
            $table->string('editeur')->nullable();
            $table->year('annee_publication')->nullable();
            $table->string('categorie')->nullable();
            $table->text('description')->nullable();
            $table->integer('nombre_exemplaires')->default(1);
            $table->integer('exemplaires_disponibles')->default(1);
            $table->string('localisation')->nullable(); // Étagère/rayon
            $table->string('couverture')->nullable(); // Image
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
