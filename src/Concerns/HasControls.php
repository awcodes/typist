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
            Actions\MobileViewport::make('controlToggleMobileViewport'),
            Actions\TabletViewport::make('controlToggleTabletViewport'),
            Actions\DesktopViewport::make('controlToggleDesktopViewport'),
            Actions\Undo::make('controlUndo'),
            Actions\Redo::make('controlRedo'),
            Actions\ClearContent::make('controlClearContent'),
            Actions\EnterFullscreen::make('controlEnterFullscreen'),
            Actions\ExitFullscreen::make('controlExitFullscreen'),
            Actions\ToggleSidebar::make('controlToggleSidebar'),
        ];
    }
}
