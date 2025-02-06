<?php

namespace Awcodes\Typist;

use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Concerns\HasExtraInputAttributes;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasPlaceholder;
use Illuminate\Support\Collection;
use Livewire\Component;

class TypistEditor extends Field
{
    use Concerns\HasBubbleMenus;
    use Concerns\HasControls;
    use Concerns\HasCustomStyles;
    use Concerns\HasMentions;
    use Concerns\HasMergeTags;
    use Concerns\HasSidebar;
    use Concerns\HasSuggestions;
    use Concerns\HasToolbar;
    use Concerns\InteractsWithBlocks;
    use Concerns\InteractsWithMedia;
    use HasExtraInputAttributes;
    use HasPlaceholder;

    protected string $view = 'typist::typist-editor';

    protected array | Closure | null $headingLevels = null;

    protected string | Closure | null $customDocument = null;

    protected bool | Closure | null $wordCount = null;

    protected array | bool | Closure $enableInputRules = true;

    protected array | bool | Closure $enablePasteRules = true;

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

    public function getAllActions(): Collection
    {
        return collect([
            ...$this->getControls(),
            ...$this->getSuggestions(),
            ...$this->getBubbleMenuActions(),
            ...$this->getSidebarActions(),
            ...$this->getToolbarActions(),
        ]);
    }

    public function getActionsToRegister(): array
    {
        return $this->getAllActions()
            ->map(function ($action) {
                return fn (): Action => $action;
            })
            ->toArray();
    }

    public function getAllowedExtensions(): array
    {
        return $this->getAllActions()
            ->map(function ($action) {
                return $action->getJsExtension();
            })
            ->unique()
            ->toArray();
    }

    public function headingLevels(array | Closure $levels): static
    {
        $this->headingLevels = $levels;

        return $this;
    }

    public function getHeadingLevels(): array
    {
        return $this->evaluate($this->headingLevels) ?? [1, 2, 3];
    }

    public function customDocument(string | Closure | null $customDocument): static
    {
        $this->customDocument = $customDocument;

        return $this;
    }

    public function getCustomDocument(): ?string
    {
        return $this->evaluate($this->customDocument);
    }

    public function wordCount(bool | Closure $wordCount = true): static
    {
        $this->wordCount = $wordCount;

        return $this;
    }

    public function shouldShowWordCount(): bool
    {
        return $this->evaluate($this->wordCount) ?? false;
    }

    public function enableInputRules(array | bool | Closure $rules = true): static
    {
        $this->enableInputRules = $rules;

        return $this;
    }

    public function enablePasteRules(array | bool | Closure $rules = true): static
    {
        $this->enablePasteRules = $rules;

        return $this;
    }

    public function getEnableInputRules(): bool | array
    {
        return $this->evaluate($this->enableInputRules);
    }

    public function getEnablePasteRules(): bool | array
    {
        return $this->evaluate($this->enablePasteRules);
    }
}
