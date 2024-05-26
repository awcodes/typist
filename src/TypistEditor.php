<?php

namespace Awcodes\Typist;

use Awcodes\Typist\Concerns\InteractsWithBlocks;
use Awcodes\Typist\Concerns\InteractsWithMedia;
use Awcodes\Typist\Support\ToolbarGroup;
use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Concerns\HasExtraInputAttributes;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasPlaceholder;
use Livewire\Component;

class TypistEditor extends Field
{
    use HasExtraInputAttributes;
    use HasPlaceholder;
    use InteractsWithBlocks;
    use InteractsWithMedia;

    protected string $view = 'typist::typist-editor';

    protected array | Closure | null $headingLevels = null;

    protected array | Closure $mergeTags = [];

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
            ->all();
    }

    public function getToolbar(): array
    {
        return [
            ToolbarGroup::make([
                $this->getAction('ParagraphAction'),
                $this->getAction('HeadingOneAction'),
                $this->getAction('HeadingTwoAction'),
                $this->getAction('HeadingThreeAction'),
                $this->getAction('HeadingFourAction'),
                $this->getAction('HeadingFiveAction'),
                $this->getAction('HeadingSixAction'),
            ]),
            $this->getAction('BoldAction'),
            $this->getAction('ItalicAction'),
            $this->getAction('StrikeAction'),
            $this->getAction('UnderlineAction'),
            $this->getAction('LinkAction'),
            $this->getAction('MediaAction'),
            $this->getAction('BulletListAction'),
            $this->getAction('OrderedListAction'),
            $this->getAction('BlockquoteAction'),
            $this->getAction('HorizontalRuleAction'),
            $this->getAction('CodeBlockAction'),
            $this->getAction('CodeAction'),
            $this->getAction('DetailsAction'),
            $this->getAction('GridAction'),
            $this->getAction('AlignStartAction'),
            $this->getAction('AlignCenterAction'),
            $this->getAction('AlignEndAction'),
            $this->getAction('AlertAction'),
        ];
    }

    public function getControls(): array
    {
        return [
            $this->getAction('UndoAction'),
            $this->getAction('RedoAction'),
            $this->getAction('ClearContentAction'),
            $this->getAction('SidebarAction'),
        ];
    }

    public function getBubbleTools(): array
    {
        return [
            $this->getAction('LinkAction'),
            $this->getAction('UnlinkAction'),
            $this->getAction('MediaAction'),
            $this->getAction('RemoveMediaAction'),
        ];
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

    public function mergeTags(array | Closure $mergeTags): static
    {
        $this->mergeTags = $mergeTags;

        return $this;
    }

    public function getMergeTags(): array
    {
        return $this->evaluate($this->mergeTags) ?? [];
    }
}
