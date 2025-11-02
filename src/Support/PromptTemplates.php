<?php

namespace OmDiaries\AIEmailAssistant\Support;

class PromptTemplates
{
    /**
     * Default built-in templates (used when no custom file exists)
     */
    protected static array $defaults = [
        'welcome' => "Subject: Welcome to {{product}}\n\nHello {{customer_name}},\n\nWelcome to {{product}}! We're excited to have you.\n\nBest regards,\n{{company_name}}",
        'follow_up' => "Subject: Checking in about {{product}}\n\nHi {{customer_name}},\n\nJust following up regarding {{product}}.\n\nCheers,\n{{company_name}}",
        'invoice' => "Subject: Invoice Reminder for {{product}}\n\nHi {{customer_name}},\n\nJust a friendly reminder about your payment for {{product}}.\n\nThanks,\n{{company_name}}",
        'support' => "Subject: Support Request for {{product}}\n\nHi {{customer_name}},\n\nWe’ve received your request about {{product}} and will get back to you soon.\n\nKind regards,\n{{company_name}}",
    ];

    /**
     * Get a template by name (with tone + format support)
     *
     * @param string $name
     * @param string $tone   formal | friendly | marketing
     * @param string $output plain | html
     * @return string
     */
    public static function get(string $name, string $tone = 'friendly', string $output = 'plain'): string
    {
        $basePath = resource_path('ai-templates');

        $txtPath = "{$basePath}/{$name}.txt";
        $htmlPath = "{$basePath}/{$name}.html";

        // Load HTML version if requested
        if ($output === 'html' && file_exists($htmlPath)) {
            return file_get_contents($htmlPath);
        }

        // Fallback to text version
        if (file_exists($txtPath)) {
            return file_get_contents($txtPath);
        }

        // Fallback to built-in defaults
        $template = static::$defaults[$name] ?? static::$defaults['welcome'];

        // Append tone and format context to help AI generate properly
        $meta = "\n\n[Tone: {$tone} | Output: {$output}]";
        return $template . $meta;
    }
}
