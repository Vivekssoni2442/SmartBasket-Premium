<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
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

    /*
    |--------------------------------------------------------------------------
    | Groq
    |--------------------------------------------------------------------------
    */

    'groq' => [
        'key' => env('GROQ_API_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Smart Basket Customer AI
    |--------------------------------------------------------------------------
    */

    'customer_ai' => [

        'provider' => env('AI_PROVIDER', 'groq'),

        'key' => env('AI_API_KEY') ?: env('GROQ_API_KEY'),

        'base_url' => env(
            'AI_BASE_URL',
            'https://api.groq.com/openai/v1/chat/completions'
        ),

        'model' => env(
            'AI_MODEL',
            env('CUSTOMER_AI_MODEL', 'openai/gpt-oss-20b')
        ),

        'timeout' => (int) env('AI_TIMEOUT', 30),

        'max_steps' => (int) env('AI_MAX_STEPS', 5),
    ],

    /*
    |--------------------------------------------------------------------------
    | Smart AI Web Search
    |--------------------------------------------------------------------------
    |
    | This allows Smart AI to get fresh internet information.
    | Tavily API key must be configured in .env.
    |
    */

    'customer_ai_web' => [

        'provider' => env('AI_WEB_PROVIDER', 'tavily'),

        'key' => env('TAVILY_API_KEY'),

        'url' => env(
            'AI_WEB_SEARCH_URL',
            'https://api.tavily.com/search'
        ),

        'timeout' => (int) env('AI_WEB_TIMEOUT', 15),

        'results' => (int) env('AI_WEB_RESULTS', 5),
    ],

    /*
    |--------------------------------------------------------------------------
    | AI Camera Assistant — Vision Provider
    |--------------------------------------------------------------------------
    */

    'ai_vision' => [

        'provider' => env('AI_VISION_PROVIDER', 'local'),

        'groq' => [
            'key' => env('GROQ_API_KEY'),

            'url' => 'https://api.groq.com/openai/v1/chat/completions',

            'model' => env(
                'AI_VISION_GROQ_MODEL',
                'llama-3.2-11b-vision-preview'
            ),
        ],

        'openai' => [
            'key' => env('OPENAI_API_KEY'),

            'url' => 'https://api.openai.com/v1/chat/completions',

            'model' => env(
                'AI_VISION_OPENAI_MODEL',
                'gpt-4o-mini'
            ),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Virtual Try-On
    |--------------------------------------------------------------------------
    */

    'virtual_tryon' => [

        'provider' => env('VIRTUAL_TRYON_PROVIDER'),

        'timeout' => (int) env('VIRTUAL_TRYON_TIMEOUT', 90),

        'openai' => [
            'key' => env('VIRTUAL_TRYON_API_KEY'),

            'url' => env(
                'VIRTUAL_TRYON_BASE_URL',
                'https://api.openai.com/v1/images/edits'
            ),

            'model' => env(
                'VIRTUAL_TRYON_MODEL',
                'gpt-image-1'
            ),

            'size' => env(
                'VIRTUAL_TRYON_SIZE',
                '1024x1024'
            ),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Razorpay
    |--------------------------------------------------------------------------
    */

    'razorpay' => [

        'key' => env('RAZORPAY_KEY'),

        'secret' => env('RAZORPAY_SECRET'),

        'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),
    ],

];