<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ReferentielModel;
use App\Services\FirebaseService;

class ReferentielServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('referentiel.model', function ($app) {
            return new ReferentielModel(
                $app->make(FirebaseService::class),
                '', // libelle
                '', // etat
                [], // competencesBack (tableau vide)
                [], // competencesFront (tableau vide)
                []  // apprenants (tableau vide)
            );
        });
    }

    public function boot()
    
    {
        //
    }
}
