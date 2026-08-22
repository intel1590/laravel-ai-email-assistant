<?php

namespace OmDiaries\AIEmailAssistant\Adapters;

use OmDiaries\AIEmailAssistant\Contracts\AIClientInterface;
use Illuminate\Support\Facades\Http;

class OpenAIAdapter implements AIClientInterface
{
    /**
     * Generic AI text generation.
     *
     * @param string $prompt
     * @param array $options
     * @return string
     */
    public function generate(string $prompt, array $options = []): string
    {
        $apiKey = config('aiemail.providers.openai.api_key');
        $model = $options['model']
            ?? config('aiemail.providers.openai.model');

        if (!$apiKey) {
            return 'Error: OpenAI API key not configured.';
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => $options['temperature'] ?? 0.2,
            ]);

            if ($response->failed()) {
                return 'Error: Failed to connect to OpenAI API - ' . $response->body();
            }

            return $response->json('choices.0.message.content')
                ?? 'Error: No valid response from OpenAI.';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    /**
     * Generate an AI-powered email using OpenAI API.
     *
     * @param string $prompt
     * @param string $tone
     * @param string $output
     * @return string
     */
    public function generateEmail(
        string $prompt,
        string $tone = 'friendly',
        string $output = 'plain'
    ): string {
        $apiKey = config('aiemail.providers.openai.api_key');
        $model = config('aiemail.providers.openai.model');

        if (!$apiKey) {
            return 'Error: OpenAI API key not configured.';
        }

        $systemMessage = sprintf(
            'You are a professional email writer. Write the email in a %s tone. Respond in %s format (%s content only).',
            $tone,
            strtoupper($output),
            $output === 'html' ? 'HTML' : 'plain text'
        );

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemMessage,
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
            ]);

            if ($response->failed()) {
                return 'Error: Failed to connect to OpenAI API - ' . $response->body();
            }

            return $response->json('choices.0.message.content')
                ?? 'Error: No valid response from OpenAI.';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}