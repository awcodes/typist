<?php

namespace Awcodes\Typist;

use Closure;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TypistManager
{
    protected array | Closure $actions = [];

    protected array $registeredActionPaths = [];

    public function registerActionPath(string $path, string $namespace): static
    {
        if (! File::isDirectory($path) || in_array($path, $this->registeredActionPaths)) {
            return $this;
        }

        $actions = collect(File::allFiles($path))
            ->map(
                fn ($file) => Str::of($file->getRelativePathname())
                    ->before('.php')
                    ->replace('/', '\\')
                    ->start($namespace . '\\')
                    ->toString()
            )
            ->filter(fn ($action) => is_subclass_of($action, Action::class))
            ->mapWithKeys(function ($action) {
                $action = $action::make(class_basename($action));

                return [$action->getName() => $action];
            })
            ->all();

        $this->actions = [...$actions];
        $this->registeredActionPaths[] = $path;

        return $this;
    }

    public function getActions(): array
    {
        return $this->actions ?? [];
    }
}
