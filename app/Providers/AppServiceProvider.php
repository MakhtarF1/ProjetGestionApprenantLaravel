<?php

namespace App\Providers;

use App\Repositories\ApprenantRepository;
use App\Repositories\Interfaces\PromotionRepositoryInterface;
use App\Repositories\PromotionRepository;
use App\Repositories\ReferentielRepository;
use App\Services\ApprenantService;
use App\Services\Interfaces\ApprenantServiceInterface;
use App\Services\Interfaces\ReferentielServiceInterface;
use App\Services\ReferentielService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Autres bindings si nécessaire
        $this->app->bind(ApprenantServiceInterface::class, ApprenantService::class);
        $this->app->bind('App\Repositories\Interfaces\ApprenantRepositoryInterface', 'App\Repositories\ApprenantRepository');
        $this->app->singleton('apprenant.model', ApprenantRepository::class);
        $this->app->bind(ReferentielServiceInterface::class, ReferentielService::class);
        $this->app->bind('App\Repositories\Interfaces\ReferentielRepositoryInterface', 'App\Repositories\ReferentielRepository');
        $this->app->singleton('referentiel.model', ReferentielRepository::class);
        $this->app->bind(PromotionRepositoryInterface::class, PromotionRepository::class);

        



    }

    public function boot()
    {
        //
    }
}
