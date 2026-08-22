<?php

namespace OmDiaries\AIEmailAssistant\Services;

use OmDiaries\AIEmailAssistant\Contracts\AIClientInterface;
use OmDiaries\AIEmailAssistant\Data\EmailAnalysis;

class EmailAnalyzer
{
    public function __construct(
        protected AIClientInterface $client
    ) {
    }

    public function analyze(string $email): EmailAnalysis
    {
        $prompt = $this->buildPrompt($email);

        $response = $this->client->generate($prompt);

        $data = json_decode($response, true);

        if (!is_array($data)) {
            throw new \RuntimeException(
                'AI provider returned an invalid analysis response.'
            );
        }

        return new EmailAnalysis(
            category: $data['category'] ?? 'general',
            intent: $data['intent'] ?? 'unknown',
            sentiment: $data['sentiment'] ?? 'neutral',
            priority: $data['priority'] ?? 'medium',
            summary: $data['summary'] ?? '',
            actionItems: $data['action_items'] ?? [],
        );
    }

    protected function buildPrompt(string $email): string
    {
        return <<<PROMPT
Analyze the following email.

Return ONLY valid JSON using exactly this structure:

{
    "category": "support|billing|sales|complaint|refund|technical|feedback|marketing|general",
    "intent": "short description of the user's intent",
    "sentiment": "positive|neutral|negative|frustrated|urgent",
    "priority": "low|medium|high|urgent",
    "summary": "short summary of the email",
    "action_items": [
        "action item 1",
        "action item 2"
    ]
}

Email:
{$email}
PROMPT;
    }
}
