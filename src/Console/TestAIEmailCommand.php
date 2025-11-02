<?php

namespace OmDiaries\AIEmailAssistant\Console;

use Illuminate\Console\Command;
use AIEmail;

class TestAIEmailCommand extends Command
{
    protected $signature = 'aiemail:test 
                            {--provider=openai : Choose provider (openai or gemini)} 
                            {--tone=friendly : Email tone (friendly, formal, marketing)} 
                            {--output=plain : Output type (plain or html)}';

    protected $description = 'Test AI Email generation using your configured provider';

    public function handle()
    {
        config(['aiemail.provider' => $this->option('provider')]);
        config(['aiemail.tone' => $this->option('tone')]);
        config(['aiemail.output' => $this->option('output')]);

        $this->info("🔍 Using provider: " . config('aiemail.provider'));
        $this->info("🎨 Tone: " . config('aiemail.tone'));
        $this->info("📝 Output: " . config('aiemail.output'));

        $email = AIEmail::generate('welcome', [
            'customer_name' => 'Radhika',
            'product' => 'Om Diaries Pro',
            'company_name' => 'Om Diaries',
        ]);

        $this->newLine();
        $this->line("📧 Generated Email:");
        $this->newLine();
        $this->line($email);
    }
}
