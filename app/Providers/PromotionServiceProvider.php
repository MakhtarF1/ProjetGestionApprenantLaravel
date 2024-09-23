<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\PromotionModel;
use App\Services\FirebaseService;

class PromotionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('promotion.model', function ($app) {
            return new PromotionModel(
                $app->make(FirebaseService::class),
                [ // Passer les données sous forme de tableau
                    'libelle' => '',
                    'dateDebut' => '',
                    'dateFin' => '',
                    'duree' => 0,
                    'etat' => 'Inactif',
                    'photoCouverture' => '',
                    'referentiels' => [],
                ]
            );
        });
    }

    public function boot()
    {
        //
    }
}
