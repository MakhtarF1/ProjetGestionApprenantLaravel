<?php

namespace App\Facades;

use App\Repositories\Interfaces\ApprenantRepositoryInterface;
use Illuminate\Support\Facades\Facade;

class ApprenantRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ApprenantRepositoryInterface::class;
    }
}
