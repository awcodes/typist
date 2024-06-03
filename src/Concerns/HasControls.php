<?php

namespace Awcodes\Typist\Concerns;

use Awcodes\Typist\Facades\Typist;
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
            Typist::getAction('Undo'),
            Typist::getAction('Redo'),
            Typist::getAction('ClearContent'),
            Typist::getAction('EnterFullscreen'),
            Typist::getAction('ExitFullscreen'),
            Typist::getAction('Sidebar'),
        ];
    }
}
