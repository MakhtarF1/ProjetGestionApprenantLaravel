<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuccessResponseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Modifiez la réponse ici si nécessaire
        if ($response->status() === 200) {
            $response->setContent(json_encode([
                'success' => true,
                'data' => json_decode($response->getContent()),
            ]));
        }

        return $response;
    }
}
