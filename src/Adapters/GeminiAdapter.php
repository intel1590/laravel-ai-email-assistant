<?php

namespace OmDiaries\AIEmailAssistant\Adapters;

use Illuminate\Support\Facades\Http;
use OmDiaries\AIEmailAssistant\Contracts\AIClientInterface;
use RuntimeException;
use Throwable;

class GeminiAdapter implements AIClientInterface
{
    public function generate(string $prompt, array $options = []): string
    {
        $apiKey = config('aiemail.providers.gemini.api_key');
        $model = $options['model']
            ?? config('aiemail.providers.gemini.model', 'gemini-1.5-flash');

        if (!$apiKey) {
            throw new RuntimeException('Gemini API key is not configured.');
        }

        try {
            $response = Http::timeout($options['timeout'] ?? 30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
                    [
                        'contents' => [
                            [
                                'parts' => [
                                    [
                                        'text' => $prompt,
                                    ],
                                ],
                            ],
                        ],
                        'generationConfig' => [
                            'temperature' => $options['temperature'] ?? 0.2,
                        ],
                    ]
                );

            if ($response->failed()) {
                throw new RuntimeException(
                    'Gemini request failed with status ' . $response->status() . '.'
                );
            }

            $content = $response->json('candidates.0.content.parts.0.text');

            if (!is_string($content) || trim($content) === '') {
                throw new RuntimeException(
                    'Gemini returned an empty or invalid response.'
                );
            }

            return trim($content);
        } catch (Throwable $e) {
            if ($e instanceof RuntimeException) {
                throw $e;
            }

            throw new RuntimeException(
                'Unable to generate content using Gemini.',
                0,
                $e
            );
        }
    }

    public function generateEmail(
        string $prompt,
        string $tone = 'friendly',
        string $output = 'plain'
    ): string {
        $systemPrompt = sprintf(
            'You are a professional email writer. Write the email in a %s tone and respond in %s format (%s content only).',
            $tone,
            strtoupper($output),
            $output === 'html' ? 'HTML' : 'plain text'
        );

        return $this->generate(
            $systemPrompt . "\n\n" . $prompt
        );
    }
}
