<?php

namespace OmDiaries\AIEmailAssistant\Adapters;

use OmDiaries\AIEmailAssistant\Contracts\AIClientInterface;
use Illuminate\Support\Facades\Http;

class GeminiAdapter implements AIClientInterface
{
    public function generateEmail(string $prompt): string
    {
        $apiKey = config('aiemail.providers.gemini.api_key');
        $model = config('aiemail.providers.gemini.model');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
            'contents' => [
                ['parts' => [['text' => $prompt]]],
            ],
        ]);

        return $response->json('candidates.0.content.parts.0.text') ?? 'Error: No response from Gemini.';
    }
}
