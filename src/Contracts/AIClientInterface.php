<?php

namespace OmDiaries\AIEmailAssistant\Contracts;

interface AIClientInterface
{
    /**
     * Generic AI text generation.
     */
    public function generate(
        string $prompt,
        array $options = []
    ): string;

    /**
     * Generate an email.
     */
    public function generateEmail(
        string $prompt,
        string $tone = 'friendly',
        string $output = 'plain'
    ): string;
}