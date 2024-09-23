<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'services' => [
        'google' => [
            'client_id' => env('GOOGLE_CLIENT_ID'), // Votre ID client Google
            'client_secret' => env('GOOGLE_CLIENT_SECRET'), // Votre secret client Google
            'redirect' => env('GOOGLE_REDIRECT_URL'), // URL de redirection après l'authentification Google
        ],

        'github' => [
            'client_id' => env('GITHUB_CLIENT_ID'), // Votre ID client GitHub
            'client_secret' => env('GITHUB_CLIENT_SECRET'), // Votre secret client GitHub
            'redirect' => env('GITHUB_REDIRECT_URL'), // URL de redirection après l'authentification GitHub
        ],

        'facebook' => [
            'client_id' => env('FACEBOOK_CLIENT_ID'), // Votre ID client Facebook
            'client_secret' => env('FACEBOOK_CLIENT_SECRET'), // Votre secret client Facebook
            'redirect' => env('FACEBOOK_REDIRECT_URL'), // URL de redirection après l'authentification Facebook
        ],
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'), // Token pour Postmark
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'), // Clé d'accès AWS
        'secret' => env('AWS_SECRET_ACCESS_KEY'), // Secret d'accès AWS
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'), // Région par défaut pour AWS SES
    ],

    'resend' => [
        'key' => env('RESEND_KEY'), // Clé pour Resend
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'), // Token OAuth du bot Slack
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'), // Canal par défaut pour les notifications Slack
        ],
    ],

];
