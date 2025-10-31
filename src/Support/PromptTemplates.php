<?php

namespace OmDiaries\AIEmailAssistant\Support;

class PromptTemplates
{
    protected static array $templates = [
        'welcome' => "Subject: Welcome to {{product}}\n\nHello {{customer_name}},\n\nWelcome to {{product}}! We're excited to have you with us.\n\nBest regards,\n{{company_name}}",
        'follow_up' => "Subject: Checking in about {{product}}\n\nHello {{customer_name}},\n\nJust a quick follow-up on {{product}}...\n\nThanks,\n{{company_name}}",
        'sales_pitch' => "Subject: Discover how {{product}} can boost your business\n\nHello {{customer_name}},\n\nWe noticed you might be interested in {{product}}. Here's how it can help...\n\nCheers,\n{{company_name}}"
    ];

    public static function get(string $name): string
    {
        return static::$templates[$name] ?? "Subject: {{product}} Update\n\nHi {{customer_name}},\n\nHere's your email update.\n\nThanks,\n{{company_name}}";
    }
}