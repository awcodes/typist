<?php

namespace Awcodes\Typist;

use Closure;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TypistManager
{
    protected array | Closure $actions = [];

    public function getActions(): array
    {
        return collect(File::allFiles(__DIR__ . '/Actions'))
            ->map(
                fn ($file) => Str::of($file->getRelativePathname())
                    ->before('.php')
                    ->replace('/', '\\')
                    ->start('Awcodes\\Typist\\Actions\\')
                    ->toString()
            )
            ->filter(fn ($action) => is_subclass_of($action, Action::class))
            ->mapWithKeys(function ($action) {
                $action = $action::make(class_basename($action));

                return [$action->getName() => $action];
            })
            ->all();
    }
}
