<?php

namespace OmDiaries\AIEmailAssistant\Adapters;

use OmDiaries\AIEmailAssistant\Contracts\AIClientInterface;
use OpenAI;

class OpenAIAdapter implements AIClientInterface
{
    protected $client;

    public function __construct($apiKey)
    {
        $this->client = OpenAI::client($apiKey);
    }

    public function generateText(string $prompt): string
    {
        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return $response['choices'][0]['message']['content'] ?? '';
    }
}
