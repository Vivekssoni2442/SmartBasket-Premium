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

    'google' => [
        'client_id' => env('GOOGLE_OAUTH_CLIENT_ID'),
        'client_secret' => env('GOOGLE_OAUTH_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_OAUTH_REDIRECT_URI'),
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

        'product_results' => (int) env('AI_PRODUCT_RESULTS', 6),

        // Optional OpenAI-compatible provider used only when the primary
        // provider is unavailable. Keep credentials server-side.
        'fallback' => [
            'provider' => env('AI_FALLBACK_PROVIDER'),
            'key' => env('AI_FALLBACK_API_KEY'),
            'base_url' => env('AI_FALLBACK_BASE_URL'),
            'model' => env('AI_FALLBACK_MODEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Smart AI Web Search
    |--------------------------------------------------------------------------
    |
    | Google Gemini grounding or Tavily supplies current web sources.
    | Provider credentials stay in server-side environment configuration.
    |
    */

    'customer_ai_web' => [

        'provider' => env('AI_WEB_SEARCH_PROVIDER', 'tavily'),

        'fallback_provider' => env('AI_WEB_SEARCH_FALLBACK_PROVIDER', 'tavily'),

        'google_key' => env('GOOGLE_GEMINI_API_KEY'),

        'google_model' => env('GOOGLE_GEMINI_SEARCH_MODEL', 'gemini-2.5-flash'),

        'google_url' => 'https://generativelanguage.googleapis.com/v1beta/interactions',

        'key' => env('TAVILY_API_KEY'),

        // Tavily supports low-volume keyless search with an explicit header.
        'keyless' => env('AI_WEB_SEARCH_KEYLESS', true),

        // Keep this fixed to avoid turning configuration into an SSRF target.
        'url' => 'https://api.tavily.com/search',

        'timeout' => (int) env('AI_WEB_TIMEOUT', 15),

        'results' => (int) env('AI_WEB_RESULTS', 5),

        'cache_ttl' => (int) env('AI_WEB_CACHE_TTL', 300),
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

        'timeout' => (int) env('VIRTUAL_TRYON_TIMEOUT', 120),

        'quality' => env('VIRTUAL_TRYON_QUALITY', 'high'),

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

        'mode' => env('RAZORPAY_MODE', 'test'),

        // Prefer Razorpay's documented variable names while retaining the
        // legacy names already used by existing deployments.
        'key' => env('RAZORPAY_KEY_ID', env('RAZORPAY_KEY')),

        'secret' => env('RAZORPAY_KEY_SECRET', env('RAZORPAY_SECRET')),

        'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),
    ],

    'twilio' => [
        'sid' => env('TWILIO_ACCOUNT_SID'),
        'token' => env('TWILIO_AUTH_TOKEN'),
        'from' => env('TWILIO_FROM_NUMBER'),
        'messaging_service_sid' => env('TWILIO_MESSAGING_SERVICE_SID'),
    ],

    'whatsapp' => [
        'graph_api_version' => env('WHATSAPP_GRAPH_API_VERSION', 'v26.0'),
    ],

];
