<?php

namespace OmDiaries\AIEmailAssistant\Contracts;

interface AIClientInterface
{
    public function generateEmail(string $prompt): string;
}
