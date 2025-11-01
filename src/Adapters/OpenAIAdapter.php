<?php

namespace OmDiaries\AIEmailAssistant\Adapters;

use OmDiaries\AIEmailAssistant\Contracts\AIClientInterface;
use Illuminate\Support\Facades\Http;

class OpenAIAdapter implements AIClientInterface
{
    public function generateEmail(string $prompt): string
    {
        $apiKey = config('aiemail.providers.openai.api_key');
        $model = config('aiemail.providers.openai.model');

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => 'You are a professional email writer.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return $response->json('choices.0.message.content') ?? 'Error: No response from OpenAI.';
    }
}