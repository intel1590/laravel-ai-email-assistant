<?php

namespace OmDiaries\AIEmailAssistant\Data;

class EmailAnalysis
{
    public function __construct(
        public readonly string $category,
        public readonly string $intent,
        public readonly string $sentiment,
        public readonly string $priority,
        public readonly string $summary,
        public readonly array $actionItems = [],
    ) {
    }

    public function toArray(): array
    {
        return [
            'category' => $this->category,
            'intent' => $this->intent,
            'sentiment' => $this->sentiment,
            'priority' => $this->priority,
            'summary' => $this->summary,
            'action_items' => $this->actionItems,
        ];
    }
}