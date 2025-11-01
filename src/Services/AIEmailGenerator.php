<?php

namespace OmDiaries\AIEmailAssistant\Services;

use OmDiaries\AIEmailAssistant\Contracts\AIClientInterface;
use OmDiaries\AIEmailAssistant\Adapters\OpenAIAdapter;
use OmDiaries\AIEmailAssistant\Adapters\GeminiAdapter;
use OmDiaries\AIEmailAssistant\Support\PromptTemplates;

class AIEmailGenerator
{
    protected AIClientInterface $client;

    public function __construct()
    {
        $provider = config('aiemail.default');

        switch ($provider) {
            case 'gemini':
                $this->client = new GeminiAdapter();
                break;

            case 'openai':
            default:
                $this->client = new OpenAIAdapter();
                break;
        }
    }

    /**
     * Generate AI-powered email content
     */
    public function generate(string $type, array $data): string
    {
        $template = PromptTemplates::get($type);

        foreach ($data as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }

        $prompt = "Write a clear, natural, professional email using the following context:\n\n" . $template;

        return $this->client->generateEmail($prompt);
    }
}
