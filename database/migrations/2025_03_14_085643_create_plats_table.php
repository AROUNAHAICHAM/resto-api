<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plats', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->decimal('prix', 8, 2); // Précision pour le prix
            $table->foreignId('categorie_id')->constrained('categorie_plats')->onDelete('cascade');
            $table->string('photo')->nullable(); // Champ pour le chemin de la photo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plats');
    }
};
