<?php

namespace Awcodes\Typist\Facades;

use Awcodes\Typist\TypistManager;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Support\Facades\Facade;

/**
 * @method array getActions()
 * @method Action | null getAction(string $name)
 * @method static static registerActionPath(string $in, string $for)
 *
 * @see TypistManager
 */
class Typist extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TypistManager::class;
    }
}
