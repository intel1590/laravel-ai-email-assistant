<?php

namespace OmDiaries\AIEmailAssistant\Facades;

use Illuminate\Support\Facades\Facade;
class AIEmail extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ai-email';
    }
}