<?php

use Illuminate\Http\Request;
$port = env('PORT', 8080);

define('LARAVEL_START', microtime(true));


// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Ajout pour forcer l'écoute sur le port défini
$app->bind('Illuminate\Http\Request', function () use ($port) {
    return Request::capture()->server->set('SERVER_PORT', $port);
});

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';


// Bootstrap Laravel and handle the request...
(require_once __DIR__ . '/../bootstrap/app.php')
    ->handleRequest(Request::capture());

 // Démarrer le serveur intégré de PHP sur le port spécifié
if (php_sapi_name() === 'cli-server') {
    $app->run();
} else {
    $app->run($app['request']);
} # Commande pour démarrer l'application
