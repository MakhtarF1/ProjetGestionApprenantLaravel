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
        // Vérifie si la table 'users' n'existe pas déjà
        if (!Schema::hasTable('users')) {
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
                $table->enum('role', ['cem', 'admin', 'manager']); // Rôle de l'utilisateur avec énumération
                $table->string('password'); // Mot de passe de l'utilisateur
                $table->timestamps(); // Champs created_at et updated_at
            });
        }
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
