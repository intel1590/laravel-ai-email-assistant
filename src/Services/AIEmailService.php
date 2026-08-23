<?php

namespace OmDiaries\AIEmailAssistant\Services;

use Illuminate\Support\Facades\Log;
use OmDiaries\AIEmailAssistant\Adapters\GeminiAdapter;
use OmDiaries\AIEmailAssistant\Adapters\OpenAIAdapter;
use OmDiaries\AIEmailAssistant\Support\PromptTemplates;
use RuntimeException;
use Throwable;

class AIEmailService
{
    protected string $provider;
    protected string $tone;
    protected string $outputType;

    public function __construct()
    {
        $this->provider = config('aiemail.default', 'openai');
        $this->tone = config('aiemail.tone', 'friendly');
        $this->outputType = config('aiemail.output', 'html');
    }

    /**
     * Generate an email using a template or AI generation.
     */
    public function generate(string $templateName, array $data = []): string
    {
        $filePath = resource_path("ai-templates/{$templateName}.txt");

        /*
         * Use a file-based template when available.
         */
        if (file_exists($filePath)) {
            return $this->generateFromTemplate($filePath, $templateName, $data);
        }

        /*
         * Otherwise fall back to AI generation.
         */
        try {
            $template = PromptTemplates::get(
                $templateName,
                $this->tone,
                $this->outputType
            );

            $template = $this->replacePlaceholders($template, $data);

            $prompt = $this->buildPrompt($template);

            $client = $this->getClient();

            return $client->generateEmail(
                $prompt,
                $this->tone,
                $this->outputType
            );
        } catch (Throwable $e) {
            Log::error('AI Email Generation Error', [
                'template' => $templateName,
                'provider' => $this->provider,
                'tone' => $this->tone,
                'output' => $this->outputType,
                'exception' => $e,
            ]);

            throw new RuntimeException(
                'Unable to generate the email at this time.',
                0,
                $e
            );
        }
    }

    /**
     * Generate an email from a file-based template.
     */
    protected function generateFromTemplate(
        string $filePath,
        string $templateName,
        array $data
    ): string {
        $content = file_get_contents($filePath);

        if ($content === false) {
            throw new RuntimeException(
                "Unable to read email template '{$templateName}'."
            );
        }

        $content = $this->replacePlaceholders($content, $data);

        /*
         * Split Subject and Body.
         */
        $parts = explode('Body:', $content, 2);

        if (count($parts) < 2) {
            Log::warning(
                "Email template '{$templateName}' is missing the Body: section."
            );
        }

        $subject = trim(
            str_replace('Subject:', '', $parts[0] ?? '')
        );

        $body = trim($parts[1] ?? '');

        if ($this->outputType === 'html') {
            return "<strong>Subject:</strong> "
                . e($subject)
                . "<br><br>"
                . nl2br(e($body));
        }

        return "Subject: {$subject}\n\n{$body}";
    }

    /**
     * Replace {{variable}} placeholders.
     */
    protected function replacePlaceholders(
        string $content,
        array $data
    ): string {
        foreach ($data as $key => $value) {
            $value = (string) $value;

            if ($this->outputType === 'html') {
                $value = e($value);
            }

            $content = preg_replace(
                '/{{\s*' . preg_quote($key, '/') . '\s*}}/',
                $value,
                $content
            );
        }

        return $content;
    }

    /**
     * Resolve the configured AI provider.
     */
    protected function getClient()
    {
        return match ($this->provider) {
            'openai' => new OpenAIAdapter(),
            'gemini' => new GeminiAdapter(),
            default => throw new RuntimeException(
                "Unsupported AI provider: {$this->provider}"
            ),
        };
    }

    /**
     * Build the AI generation prompt.
     */
    protected function buildPrompt(string $template): string
    {
        $toneInstruction = match ($this->tone) {
            'formal' => 'Use a professional and polite tone.',
            'marketing' => 'Use an engaging, persuasive, and promotional tone.',
            default => 'Use a friendly and natural tone.',
        };

        $formatInstruction = $this->outputType === 'html'
            ? 'Respond with a well-formatted HTML email using valid HTML. Return email content only.'
            : 'Respond in plain text format. Return email content only.';

        return "{$toneInstruction}\n"
            . "{$formatInstruction}\n\n"
            . "Generate the following email:\n\n"
            . $template;
    }
}
