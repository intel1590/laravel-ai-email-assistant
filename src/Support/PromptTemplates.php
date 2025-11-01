<?php

namespace OmDiaries\AIEmailAssistant\Support;

class PromptTemplates
{
    protected static array $templates = [
        'welcome' => "Subject: Welcome to {{product}}\n\nHello {{customer_name}},\n\nWelcome to {{product}}! We're thrilled to have you on board.\n\nBest regards,\n{{company_name}}",

        'follow_up' => "Subject: Following up on {{product}}\n\nHi {{customer_name}},\n\nJust checking in to see how things are going with {{product}}.\n\nWarm regards,\n{{company_name}}",

        'invoice' => "Subject: Invoice / Payment Reminder\n\nDear {{customer_name}},\n\nThis is a friendly reminder that your payment for {{product}} is due on {{due_date}}.\n\nPlease let us know if you need assistance.\n\nThank you,\n{{company_name}}",

        'support' => "Subject: Support Response\n\nHi {{customer_name}},\n\nThank you for contacting {{company_name}} support. Regarding your issue — {{issue_summary}} — here’s what we suggest:\n\n{{support_reply}}\n\nBest,\n{{company_name}}",
    ];

    public static function get(string $name): string
    {
        return static::$templates[$name] ??
            "Subject: {{product}} Update\n\nHi {{customer_name}},\n\nHere's your email update.\n\nThanks,\n{{company_name}}";
    }
}
