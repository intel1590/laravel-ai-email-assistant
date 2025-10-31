<?php

return [
    'provider' => env('AI_EMAIL_PROVIDER', 'openai'),
    'openai_key' => env('OPENAI_API_KEY'),

    'client_class' => OmDiaries\AIEmailAssistant\Adapters\OpenAIAdapter::class,
];
