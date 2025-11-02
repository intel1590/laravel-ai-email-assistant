<?php

namespace OmDiaries\AIEmailAssistant\Adapters;

use OmDiaries\AIEmailAssistant\Contracts\AIClientInterface;
use Illuminate\Support\Facades\Http;

class OpenAIAdapter implements AIClientInterface
{
    /**
     * Generate an AI-powered email using OpenAI API.
     *
     * @param string $prompt  The email prompt or content idea
     * @param string $tone    The tone of the email (formal, friendly, marketing)
     * @param string $output  The output format (plain or html)
     * @return string
     */
    public function generateEmail(string $prompt, string $tone = 'friendly', string $output = 'plain'): string
    {
        $apiKey = config('aiemail.providers.openai.api_key');
        $model = config('aiemail.providers.openai.model');

        if (!$apiKey) {
            return 'Error: OpenAI API key not configured.';
        }

        // Construct system message with tone and output style
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
                    ['role' => 'system', 'content' => $systemMessage],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            if ($response->failed()) {
                return 'Error: Failed to connect to OpenAI API - ' . $response->body();
            }

            return $response->json('choices.0.message.content') ?? 'Error: No valid response from OpenAI.';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
