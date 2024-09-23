<?php

return [
    'credentials' => [
        'file' => env('FIREBASE_CREDENTIALS'), // Chemin vers votre fichier de clés de service
    ],
    'database' => [
        'url' => env('FIREBASE_DATABASE_URL'), // URL de votre base de données Firebase
    ],
];
