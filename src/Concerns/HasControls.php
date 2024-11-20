<?php

namespace Awcodes\Typist\Concerns;

use Awcodes\Typist\Actions;
use Closure;
use Filament\Forms\Components\Actions\Action;

trait HasControls
{
    protected array | Closure | null $controls = null;

    /**
     * @param  array<Action> | Closure  $actions
     */
    public function controls(array | Closure $actions): static
    {
        $this->controls = $actions;

        return $this;
    }

    /**
     * @return array<Action>
     */
    public function getControls(): array
    {
        return $this->evaluate($this->controls) ?? [
            Actions\Undo::make('Undo'),
            Actions\Redo::make('Redo'),
            Actions\ClearContent::make('ClearContent'),
            Actions\EnterFullscreen::make('EnterFullscreen'),
            Actions\ExitFullscreen::make('ExitFullscreen'),
            Actions\Sidebar::make('Sidebar'),
        ];
    }
}
