<?php

namespace OmDiaries\AIEmailAssistant\Contracts;


interface AIClientInterface
{
    public function generateEmail(string $prompt, string $tone = 'friendly', string $output = 'plain'): string;
}
