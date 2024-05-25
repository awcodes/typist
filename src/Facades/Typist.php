<?php

namespace Awcodes\Typist\Facades;

use Awcodes\Typist\TypistManager;
use Illuminate\Support\Facades\Facade;

/**
 * @see TypistManager
 */
class Typist extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TypistManager::class;
    }
}
