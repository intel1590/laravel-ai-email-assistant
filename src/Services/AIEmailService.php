<?php

namespace OmDiaries\AIEmailAssistant\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use OmDiaries\AIEmailAssistant\Support\PromptTemplates;
use OmDiaries\AIEmailAssistant\Adapters\OpenAIAdapter;
use OmDiaries\AIEmailAssistant\Adapters\GeminiAdapter;

class AIEmailService
{
    protected string $provider;
    protected string $tone;
    protected string $outputType;

    public function __construct()
    {
        $this->provider = config('aiemail.default', 'openai'); // openai | gemini
        $this->tone = config('aiemail.tone', 'friendly');      // formal | friendly | marketing
        $this->outputType = config('aiemail.output', 'html');  // plain | html
    }

    /**
     * Generate an email using AI or file-based template.
     */
    public function generate(string $templateName, array $data = []): string
    {
        $filePath = resource_path("ai-templates/{$templateName}.txt");

        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);

            // Replace placeholders {{variable}}
            foreach ($data as $key => $value) {
                $value = $this->outputType === 'html' ? e($value) : $value;
                $content = preg_replace('/{{\s*' . preg_quote($key, '/') . '\s*}}/', $value, $content);
            }

            // Split Subject and Body
            $parts = explode('Body:', $content, 2);
            if (count($parts) < 2) {
                Log::warning("Template '{$templateName}' missing Body: section");
            }

            $subject = trim(str_replace('Subject:', '', $parts[0] ?? ''));
            $body = trim($parts[1] ?? '');

            // Return formatted output
            if ($this->outputType === 'html') {
                return "<strong>Subject:</strong> {$subject}<br><br>" . nl2br($body);
            }

            return "Subject: {$subject}\n\n{$body}";
        }

        // Fallback: AI prompt-based generation
        try {
            $template = PromptTemplates::get($templateName, $this->tone, $this->outputType);

            foreach ($data as $key => $value) {
                $template = preg_replace('/{{\s*' . preg_quote($key, '/') . '\s*}}/', $value, $template);
            }

            $prompt = $this->buildPrompt($template);

            $client = $this->provider === 'gemini'
                ? new GeminiAdapter()
                : new OpenAIAdapter();

            return $client->generateEmail($prompt, $this->tone, $this->outputType);
        } catch (\Exception $e) {
            Log::error('AI Email Generation Error: ' . $e->getMessage());
            return "❌ Error generating email: " . $e->getMessage();
        }
    }

    protected function buildPrompt(string $template): string
    {
        $toneInstruction = match ($this->tone) {
            'formal' => 'Use a professional and polite tone.',
            'marketing' => 'Use an engaging, persuasive, and promotional tone.',
            default => 'Use a friendly and natural tone.',
        };

        $formatInstruction = $this->outputType === 'html'
            ? 'Respond with a well-formatted HTML email (use <html> and <body> tags).'
            : 'Respond in plain text format.';

        return "{$toneInstruction}\n{$formatInstruction}\n\nGenerate the following email:\n\n{$template}";
    }
}
