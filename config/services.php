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
'groq' => [
        'key' => env('GROQ_API_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | AI Camera Assistant — Vision provider
    |--------------------------------------------------------------------------
    | provider: 'local' (offline, fully private) | 'groq' | 'openai' (future)
    | Keys are read from .env, never hardcoded.
    */
    'ai_vision' => [
        'provider' => env('AI_VISION_PROVIDER', 'local'),
        'groq' => [
            'key'   => env('GROQ_API_KEY'),
            'url'   => 'https://api.groq.com/openai/v1/chat/completions',
            'model' => 'llama-3.2-11b-vision-preview',
        ],
        'openai' => [
            'key'   => env('OPENAI_API_KEY'),
            'url'   => 'https://api.openai.com/v1/chat/completions',
            'model' => 'gpt-4o-mini',
        ],
    ],

    // A separate capability from AI Camera Assistant vision analysis. Configure
    // only with a provider/model that accepts two images and returns an edited image.
    'virtual_tryon' => [
        'provider' => env('VIRTUAL_TRYON_PROVIDER'),
        'timeout' => env('VIRTUAL_TRYON_TIMEOUT', 90),
        'openai' => [
            'key' => env('VIRTUAL_TRYON_API_KEY'),
            'url' => env('VIRTUAL_TRYON_BASE_URL', 'https://api.openai.com/v1/images/edits'),
            'model' => env('VIRTUAL_TRYON_MODEL', 'gpt-image-1'),
            'size' => env('VIRTUAL_TRYON_SIZE', '1024x1024'),
        ],
    ],
];
