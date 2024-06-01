<?php

namespace Awcodes\Typist;

use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Concerns\HasExtraInputAttributes;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasPlaceholder;
use Livewire\Component;

class TypistEditor extends Field
{
    use Concerns\HasBubbleMenus;
    use Concerns\HasControls;
    use Concerns\HasMergeTags;
    use Concerns\HasSuggestions;
    use Concerns\HasToolbar;
    use Concerns\InteractsWithBlocks;
    use Concerns\InteractsWithMedia;
    use HasExtraInputAttributes;
    use HasPlaceholder;

    protected string $view = 'typist::typist-editor';

    protected array | Closure | null $headingLevels = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (TypistEditor $component, $state) {
            if (! $state) {
                return null;
            }

            $state = $this->renderBlockViews($state, $component);

            $component->state($state);
        });

        $this->afterStateUpdated(function (TypistEditor $component, Component $livewire): void {
            $livewire->validateOnly($component->getStatePath());
        });

        $this->dehydrateStateUsing(function ($state) {
            if (! $state) {
                return null;
            }

            return $this->sanitizeBlocksBeforeSave($state);
        });

        $this->registerListeners([]);

        $this->registerActions($this->getActionsToRegister());
    }

    public function getActionsToRegister(): array
    {
        return collect(\Awcodes\Typist\Facades\Typist::getActions())
            ->map(function ($action) {
                return fn (): Action => $action;
            })
            ->toArray();
    }

    public function headingLevels(array | Closure $levels): static
    {
        $this->headingLevels = $levels;

        return $this;
    }

    public function getHeadingLevels(): array
    {
        return $this->evaluate($this->headingLevels) ?? [1, 2, 3, 4, 5, 6];
    }
}
