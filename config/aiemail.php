<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default AI Provider
    |--------------------------------------------------------------------------
    |
    | This defines which AI engine will be used by default.
    | Supported: "openai", "gemini"
    |
    */
    'default' => env('AI_PROVIDER', 'openai'),

    /*
    |--------------------------------------------------------------------------
    | Tone of the Email
    |--------------------------------------------------------------------------
    |
    | The tone determines the writing style of generated emails.
    | Options: "formal", "friendly", "marketing", or any custom text.
    |
    */
    'tone' => env('AI_EMAIL_TONE', 'friendly'),

    /*
    |--------------------------------------------------------------------------
    | Output Format
    |--------------------------------------------------------------------------
    |
    | Choose between plain text or HTML-formatted email output.
    | Options: "plain" or "html"
    |
    */
    'output' => env('AI_EMAIL_OUTPUT', 'html'),

    /*
    |--------------------------------------------------------------------------
    | AI Providers Configuration
    |--------------------------------------------------------------------------
    |
    | You can configure API keys and models for each supported AI provider.
    |
    */
    'providers' => [

        'openai' => [
            'driver' => 'openai',
            'api_key' => env('OPENAI_API_KEY'),
            'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
        ],

        'gemini' => [
            'driver' => 'gemini',
            'api_key' => env('GEMINI_API_KEY'),
            'model' => env('GEMINI_MODEL', 'gemini-1.5-flash'),
        ],
    ],
];
