<?php

namespace App\Facades;

use App\Services\Interfaces\ApprenantServiceInterface;
use Illuminate\Support\Facades\Facade;

class ApprenantServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ApprenantServiceInterface::class;
    }
}
