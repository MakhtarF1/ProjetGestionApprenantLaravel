<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * Le nom du modèle que cette fabrique est responsable de créer.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Définissez l'état par défaut du modèle.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'adresse' => $this->faker->address,
            'telephone' => $this->faker->phoneNumber,
            'fonction' => $this->faker->word,
            'email' => $this->faker->unique()->safeEmail,
            'photo' => $this->faker->imageUrl,
            'statut' => $this->faker->randomElement(['Bloquer', 'Actif']),
            'role' => $this->faker->randomElement(['cem', 'admin', 'manager']),
            'password' => Hash::make('Password123!'), // Mot de passe hashé
        ];
    }
}
