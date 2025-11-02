<?php

namespace OmDiaries\AIEmailAssistant\Facades;

use Illuminate\Support\Facades\Facade;

class AIEmail extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'aiemail';
    }
}
