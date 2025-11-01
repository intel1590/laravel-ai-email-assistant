<?php

namespace OmDiaries\AIEmailAssistant;

use Illuminate\Support\ServiceProvider;
use OmDiaries\AIEmailAssistant\Services\AIEmailGenerator;

class AIEmailServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/aiemail.php', 'aiemail');

        $this->app->singleton('aiemail', function () {
            return new AIEmailGenerator();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/aiemail.php' => config_path('aiemail.php'),
        ], 'config');
    }
}
