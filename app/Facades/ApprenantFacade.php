<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ApprenantFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'apprenant.model'; // Correspond à l'alias enregistré
    }
}
