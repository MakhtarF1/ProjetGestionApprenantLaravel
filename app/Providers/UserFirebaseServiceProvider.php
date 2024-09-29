<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\UserFirebaseModel;
use App\Services\FirebaseService;

class UserFirebaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('user.firebase.model', function ($app) {
            // Créer un tableau d'attributs pour initialiser le modèle
            $attributes = [
                'nom' => '', // Remplacez avec les valeurs appropriées
                'prenom' => '',
                'adresse' => '',
                'telephone' => '',
                'email' => '',
                'fonction' => '',
                'photo' => '',
                'statut' => '',
                'password' => '', // Peut rester vide si non nécessaire
            ];

            // Créer une instance de UserFirebaseModel avec FirebaseService et les attributs
            return UserFirebaseModel::createWithAttributes(
                $app->make(FirebaseService::class),
                $attributes
            );
        });
    }

    public function boot()
    {
        // Code d'initialisation spécifique à l'application si nécessaire
    }
}
