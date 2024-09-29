<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ApprenantModel;
use App\Services\FirebaseService;

class ApprenantServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('apprenant.model', function ($app) {
            // Initialisation avec des valeurs par défaut
            return new ApprenantModel(
                $app->make(FirebaseService::class),
                '', // nom
                '', // prenom
                '', // adresse
                '', // telephone
                '', // email
                '', // photo
                '', // referentiel
                '', // matricule
                '', // qrCode
                [], // presences (tableau vide)
                [], // notes (tableau vide)
                false // isActive (valeur par défaut à false)
            );
        });
    }

    public function boot()
    {
        // Code à exécuter lors du démarrage du service provider
    }
}
