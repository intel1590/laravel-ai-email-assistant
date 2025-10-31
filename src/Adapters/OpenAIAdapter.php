<?php

namespace OmDiaries\AIEmailAssistant\Adapters;

use OmDiaries\AIEmailAssistant\Contracts\AIClientInterface;
use OpenAI;

class OpenAIAdapter implements AIClientInterface
{
    protected $client;

    public function __construct($apiKey)
    {
        // ✅ Properly create OpenAI client using the key
        $this->client = OpenAI::client($apiKey);
    }

    public function complete(string $prompt, array $options = []): string
    {
        $model = $options['model'] ?? 'gpt-3.5-turbo';
        $tone = $options['tone'] ?? 'professional';

        $response = $this->client->chat()->create([
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => "You are a helpful assistant that writes $tone emails."],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return $response['choices'][0]['message']['content'] ?? '';
    }
}
