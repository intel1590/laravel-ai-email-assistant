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
        $this->mergeConfigFrom(__DIR__.'/../config/aiemail.php', 'aiemail');

        $this->app->singleton(AIEmailGenerator::class, function ($app) {
            $client = $app->make(config('aiemail.client_class'));
            return new AIEmailGenerator($client, config('aiemail'));
        });

        $this->app->alias(AIEmailGenerator::class, 'ai-email');
    }
}