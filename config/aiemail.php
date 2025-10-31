<?php

return [
    'client_class' => env('AIEMAIL_CLIENT_CLASS', OmDiaries\\AIEmailAssistant\\Support\\Adapters\\OpenAIAdapter::class),
    'default_options' => [
        'temperature' => 0.7,
        'max_tokens' => 800,
    ],
    'openai_api_key' => env('OPENAI_API_KEY', ''),
    'track_emails' => true,
];