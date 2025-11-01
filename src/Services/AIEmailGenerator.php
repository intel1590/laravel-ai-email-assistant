<?php

namespace OmDiaries\AIEmailAssistant\Services;

use OmDiaries\AIEmailAssistant\Contracts\AIClientInterface;

class AIEmailGenerator
{
    protected AIClientInterface $client;
    protected array $config;

    public function __construct(AIClientInterface $client, array $config = [])
    {
        $this->client = $client;
        $this->config = $config;
    }

    public function generate(string $templateName, array $details = [], array $options = []): array
    {
        // ✅ 1. Check for demo mode (set via config or .env)
        if (config('aiemail.demo_mode', false)) {
            return [
                'subject' => 'Welcome to ' . ($details['company_name'] ?? 'Our Company'),
                'body' => "Hi " . ($details['customer_name'] ?? 'there') . ",\n\n" .
                          "We're excited to have you try our " . ($details['product'] ?? 'AI Email Assistant') . "!\n" .
                          "This is a sample email generated in demo mode.\n\n" .
                          "Cheers,\nThe " . ($details['company_name'] ?? 'OM Diaries') . " Team"
            ];
        }

        // 🧠 2. Proceed normally with real API call
        $template = \OmDiaries\AIEmailAssistant\Support\PromptTemplates::get($templateName);
        $prompt = $this->buildPrompt($template, $details, $options);
        $result = $this->client->complete($prompt, array_merge($this->config['default_options'] ?? [], $options));

        $parts = preg_split('/\r?\n\r?\n|###/', trim($result), 2);

        return [
            'subject' => $parts[0] ?? '',
            'body' => $parts[1] ?? $parts[0] ?? '',
        ];
    }

    protected function buildPrompt(string $template, array $details = [], array $options = []): string
    {
        $prompt = $template;
        foreach ($details as $key => $value) {
            $prompt = str_replace("{{{$key}}}", $value, $prompt);
        }

        if (!empty($options['tone'])) {
            $prompt = "Tone: " . $options['tone'] . "\n" . $prompt;
        }
        return $prompt;
    }
}
