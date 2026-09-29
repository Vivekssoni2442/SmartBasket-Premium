<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    */

    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    */

    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',

            'scheme' => env('MAIL_SCHEME', 'smtp'),

            'host' => env('MAIL_HOST', 'smtp.gmail.com'),

            'port' => (int) env('MAIL_PORT', 587),

            'username' => env('MAIL_USERNAME'),

            'password' => env('MAIL_PASSWORD'),

            'timeout' => (int) env('MAIL_TIMEOUT', 30),

            'local_domain' => env(
                'MAIL_EHLO_DOMAIN',
                parse_url(
                    (string) env('APP_URL', 'http://localhost'),
                    PHP_URL_HOST
                ) ?: 'localhost'
            ),

            'verify_peer' => filter_var(
                env('MAIL_VERIFY_PEER', true),
                FILTER_VALIDATE_BOOLEAN
            ),
        ],

        /*
        |--------------------------------------------------------------------------
        | Gmail TLS - Port 587
        |--------------------------------------------------------------------------
        */

        'gmail_tls' => [
            'transport' => 'smtp',
            'scheme' => 'smtp',
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => 30,

            'local_domain' => env(
                'MAIL_EHLO_DOMAIN',
                parse_url(
                    (string) env('APP_URL', 'http://localhost'),
                    PHP_URL_HOST
                ) ?: 'localhost'
            ),

            'verify_peer' => true,
        ],

        /*
        |--------------------------------------------------------------------------
        | Gmail SSL - Port 465
        |--------------------------------------------------------------------------
        */

        'gmail_ssl' => [
            'transport' => 'smtp',
            'scheme' => 'smtps',
            'host' => 'smtp.gmail.com',
            'port' => 465,
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => 30,

            'local_domain' => env(
                'MAIL_EHLO_DOMAIN',
                parse_url(
                    (string) env('APP_URL', 'http://localhost'),
                    PHP_URL_HOST
                ) ?: 'localhost'
            ),

            'verify_peer' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    */

    'from' => [
        'address' => env(
            'MAIL_FROM_ADDRESS',
            env('MAIL_USERNAME')
        ),

        'name' => env(
            'MAIL_FROM_NAME',
            'SMART BASKET PREMIUM'
        ),
    ],

];