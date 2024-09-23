<?php

namespace App\Providers;

use App\Models\UserPostgresModel;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        UserPostgresModel::class => UserPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
