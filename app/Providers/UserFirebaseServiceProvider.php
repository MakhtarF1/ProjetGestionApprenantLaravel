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
            return new UserFirebaseModel(
                $app->make(FirebaseService::class),
                '', // nom
                '', // prenom
                '', // adresse
                '', // telephone
                '', // email
                '', // fonction
                '', // photo
                '', // statut
                ''  // password
            );
        });
    }

    public function boot()
    {
        //
    }
}
