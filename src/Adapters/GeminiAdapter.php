<?php

namespace OmDiaries\AIEmailAssistant\Adapters;

use OmDiaries\AIEmailAssistant\Contracts\AIClientInterface;
use Illuminate\Support\Facades\Http;

class GeminiAdapter implements AIClientInterface
{
    /**
     * Generate an AI-powered email using Gemini API.
     *
     * @param string $prompt  The email prompt or content idea
     * @param string $tone    The tone of the email (formal, friendly, marketing)
     * @param string $output  The output format (plain or html)
     * @return string
     */
    public function generateEmail(string $prompt, string $tone = 'friendly', string $output = 'plain'): string
    {
        $apiKey = config('aiemail.providers.gemini.api_key');
        $model = config('aiemail.providers.gemini.model');

        if (!$apiKey) {
            return 'Error: Gemini API key not configured.';
        }

        // Build tone and output context
        $systemPrompt = sprintf(
            "You are a professional email writer. Write the email in a %s tone and respond in %s format (%s content only).",
            $tone,
            strtoupper($output),
            $output === 'html' ? 'HTML' : 'plain text'
        );

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemPrompt],
                            ['text' => $prompt],
                        ],
                    ],
                ],
            ]);

            if ($response->failed()) {
                return 'Error: Failed to connect to Gemini API - ' . $response->body();
            }

            return $response->json('candidates.0.content.parts.0.text')
                ?? 'Error: No valid response from Gemini.';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
