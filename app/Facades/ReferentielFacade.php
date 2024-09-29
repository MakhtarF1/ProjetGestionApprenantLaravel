<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ReferentielFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'referentiel.model'; // Vérifiez que c'est le même que dans le service provider
    }
}
