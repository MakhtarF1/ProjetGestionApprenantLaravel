<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID de l'utilisateur
            $table->string('nom'); // Nom de l'utilisateur
            $table->string('prenom'); // Prénom de l'utilisateur
            $table->string('adresse'); // Adresse de l'utilisateur
            $table->string('telephone'); // Téléphone de l'utilisateur
            $table->string('fonction'); // Fonction de l'utilisateur
            $table->string('email')->unique(); // Email unique de l'utilisateur
            $table->string('photo')->nullable(); // Photo de l'utilisateur
            $table->enum('statut', ['Bloquer', 'Actif'])->default('Actif'); // Statut de l'utilisateur
            $table->foreignId('role_id') // Clé étrangère vers roles
                  ->constrained('roles')
                  ->onDelete('cascade'); // Suppression en cascade si un rôle est supprimé
            $table->timestamps(); // Champs created_at et updated_at
        });
    }
    
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
