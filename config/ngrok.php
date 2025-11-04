<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Ngrok Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for ngrok tunneling service
    |
    */

    'enabled' => env('NGROK_ENABLED', false),
    'url' => env('NGROK_URL', null),
    'domain' => env('NGROK_DOMAIN', null),
];

