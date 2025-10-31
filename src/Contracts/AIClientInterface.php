<?php

namespace OmDiaries\AIEmailAssistant\Contracts;

interface AIClientInterface
{
    public function complete(string $prompt, array $options = []): string;
}