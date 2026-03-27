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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->date('date_emprunt');
            $table->date('date_retour_prevue');
            $table->date('date_retour_effective')->nullable();
            $table->enum('statut', ['en_cours', 'retourne', 'en_retard'])->default('en_cours');
            $table->text('notes')->nullable();
            $table->boolean('notification_retard_envoyee')->default(false);
            $table->foreignId('bibliothecaire_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
