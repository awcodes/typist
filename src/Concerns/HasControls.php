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
            Actions\Undo::make('controlsUndo'),
            Actions\Redo::make('controlsRedo'),
            Actions\ClearContent::make('controlsClearContent'),
            Actions\EnterFullscreen::make('controlsEnterFullscreen'),
            Actions\ExitFullscreen::make('controlsExitFullscreen'),
            Actions\Sidebar::make('controlsSidebar'),
        ];
    }
}
