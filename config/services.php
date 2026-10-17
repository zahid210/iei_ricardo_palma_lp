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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'google' => [
        'maps_key' => env('GOOGLE_MAPS_KEY'),
    ],

    /*
     * Feed de la página de Facebook que se muestra en /noticias.
     *
     * El "Page Plugin" oficial (iframe) dejó de cargar el timeline a nivel
     * global (solo muestra la cabecera), así que traemos las publicaciones con
     * la Graph API desde el servidor. El token se genera en el panel de
     * desarrolladores de Facebook y se guarda SOLO en el .env del servidor
     * (nunca en el repositorio: el repo es público).
     */
    'facebook' => [
        'page_id' => env('FACEBOOK_PAGE_ID', '279471448578826'),
        'token' => env('FACEBOOK_PAGE_TOKEN'),
        'version' => env('FACEBOOK_GRAPH_VERSION', 'v21.0'),
    ],

];
