<?php

namespace ymlluo\Ueditor\Facades;

use Illuminate\Support\Facades\Facade;

class Ueditor extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ueditor';
    }
}
