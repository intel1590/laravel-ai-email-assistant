<?php

namespace OmDiaries\AIEmailAssistant;

use Illuminate\Support\ServiceProvider;
use OmDiaries\AIEmailAssistant\Services\AIEmailService;
use OmDiaries\AIEmailAssistant\Console\TestAIEmailCommand;

class AIEmailServiceProvider extends ServiceProvider
{
    /**
     * Register package services.
     */
    public function register()
    {
        // Merge default config
        $this->mergeConfigFrom(__DIR__ . '/../config/aiemail.php', 'aiemail');

        // Bind singleton service
        $this->app->singleton('aiemail', function () {
            return new AIEmailService();
        });
    }

    /**
     * Bootstrap any package services.
     */
    public function boot()
    {
        // Allow publishing config file
        $this->publishes([
            __DIR__ . '/../config/aiemail.php' => config_path('aiemail.php'),
        ], 'config');

        // ✅ Register Artisan test command
        if ($this->app->runningInConsole()) {
            $this->commands([
                TestAIEmailCommand::class,
            ]);
        }
    }
}