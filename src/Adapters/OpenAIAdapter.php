<?php

namespace OmDiaries\AIEmailAssistant\Adapters;

use Illuminate\Support\Facades\Http;
use OmDiaries\AIEmailAssistant\Contracts\AIClientInterface;
use RuntimeException;
use Throwable;

class OpenAIAdapter implements AIClientInterface
{
    public function generate(string $prompt, array $options = []): string
    {
        $apiKey = config('aiemail.providers.openai.api_key');
        $model = $options['model']
            ?? config('aiemail.providers.openai.model', 'gpt-4o-mini');

        if (!$apiKey) {
            throw new RuntimeException('OpenAI API key is not configured.');
        }

        try {
            $response = Http::timeout($options['timeout'] ?? 30)
                ->withToken($apiKey)
                ->post('https://api.openai.com/v1/chat/completions', [
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
                throw new RuntimeException(
                    'OpenAI request failed with status ' . $response->status() . '.'
                );
            }

            $content = $response->json('choices.0.message.content');

            if (!is_string($content) || trim($content) === '') {
                throw new RuntimeException(
                    'OpenAI returned an empty or invalid response.'
                );
            }

            return trim($content);
        } catch (Throwable $e) {
            if ($e instanceof RuntimeException) {
                throw $e;
            }

            throw new RuntimeException(
                'Unable to generate content using OpenAI.',
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
        $systemMessage = sprintf(
            'You are a professional email writer. Write the email in a %s tone. Respond in %s format (%s content only).',
            $tone,
            strtoupper($output),
            $output === 'html' ? 'HTML' : 'plain text'
        );

        return $this->generate(
            $systemMessage . "\n\n" . $prompt
        );
    }
}
