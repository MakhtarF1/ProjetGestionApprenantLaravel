<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

interface AuthServiceInterface
{
    public function authenticate(array $credentials): JsonResponse;
}
