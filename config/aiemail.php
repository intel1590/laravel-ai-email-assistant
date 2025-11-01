<?php

return [

    'default' => env('AI_PROVIDER', 'openai'),

    'providers' => [

        'openai' => [
            'driver' => 'openai',
            'api_key' => env('OPENAI_API_KEY'),
            'model' => 'gpt-4o-mini',
        ],

        'gemini' => [
            'driver' => 'gemini',
            'api_key' => env('GEMINI_API_KEY'),
            'model' => 'gemini-1.5-flash',
        ],
    ],
];
