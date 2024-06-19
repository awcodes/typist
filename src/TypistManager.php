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

    public function registerActionPath(string $in, string $for): static
    {
        if (! File::isDirectory($in) || in_array($in, $this->registeredActionPaths)) {
            return $this;
        }

        $actions = collect(File::allFiles($in))
            ->map(
                fn ($file) => Str::of($file->getRelativePathname())
                    ->before('.php')
                    ->replace('/', '\\')
                    ->start($for . '\\')
                    ->toString()
            )
            ->filter(fn ($action) => is_subclass_of($action, Action::class))
            ->mapWithKeys(function ($action) {
                $action = $action::make(class_basename($action));

                return [$action->getName() => $action];
            })
            ->all();

        $this->actions = [...$this->actions, ...$actions];
        $this->registeredActionPaths[] = $in;

        return $this;
    }

    public function getActions(): array
    {
        return $this->actions ?? [];
    }

    public function getAction(string $name): ?Action
    {
        return $this->getActions()[$name] ?? null;
    }
}
