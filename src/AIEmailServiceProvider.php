<?php

namespace OmDiaries\AIEmailAssistant;

use Illuminate\Support\ServiceProvider;
use OmDiaries\AIEmailAssistant\Services\AIEmailGenerator;

class AIEmailServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/aiemail.php' => config_path('aiemail.php'),
        ], 'aiemail-config'); // 👈 changed tag name
    }

    public function register()
{
    $this->mergeConfigFrom(__DIR__ . '/../config/aiemail.php', 'aiemail');

    $this->app->singleton(AIEmailGenerator::class, function ($app) {
        $clientClass = config('aiemail.client_class');
        $apiKey = config('aiemail.openai_key');
        $client = new $clientClass($apiKey);

        return new AIEmailGenerator($client, config('aiemail'));
    });

    // 👇 add this line to create an alias for app('ai-email')
    $this->app->alias(AIEmailGenerator::class, 'ai-email');
}


}