<?php

namespace OmDiaries\AIEmailAssistant\Services;

use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
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
     * Generate an email using a template and the configured AI provider.
     *
     * @param string $templateName
     * @param array $data
     * @return string
     */
    public function generate(string $templateName, array $data = []): string
    {
        try {
            /*
             * Resolve the template through PromptTemplates.
             *
             * This supports:
             * - HTML templates
             * - Plain text templates
             * - Built-in templates
             */
            $template = PromptTemplates::get(
                $templateName,
                $this->tone,
                $this->outputType
            );

            /*
             * Replace {{variable}} placeholders.
             */
            $template = $this->replacePlaceholders($template, $data);

            /*
             * Build the AI prompt.
             */
            $prompt = $this->buildPrompt($template);

            /*
             * Resolve the configured AI provider.
             */
            $client = $this->getClient();

            /*
             * Generate the final email.
             */
            return $client->generateEmail(
                $prompt,
                $this->tone,
                $this->outputType
            );
        } catch (InvalidArgumentException $e) {
            Log::warning('AI Email Template Error', [
                'template' => $templateName,
                'message' => $e->getMessage(),
            ]);

            throw $e;
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
     * Replace {{variable}} placeholders in the template.
     */
    protected function replacePlaceholders(
        string $content,
        array $data
    ): string {
        foreach ($data as $key => $value) {
            $value = (string) $value;

            /*
             * Escape dynamic values when generating HTML.
             */
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
    protected function getClient(): OpenAIAdapter|GeminiAdapter
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
     * Build the prompt sent to the AI provider.
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
