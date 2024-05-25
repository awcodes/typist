<?php

namespace Awcodes\Typist;

use Awcodes\Typist\Concerns\InteractsWithMedia;
use Awcodes\Typist\Support\ToolbarGroup;
use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Concerns\HasExtraInputAttributes;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasPlaceholder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;

class TypistEditor extends Field
{
    use HasPlaceholder;
    use HasExtraInputAttributes;
    use InteractsWithMedia;

    protected string $view = 'typist::typist-editor';

    protected array | Closure | null $headingLevels = null;

    protected array | Closure $mergeTags = [];

    protected bool | Closure | null $relativePaths = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateUpdated(function (TypistEditor $component, Component $livewire): void {
            $livewire->validateOnly($component->getStatePath());
        });

        $this->dehydrateStateUsing(function ($state) {
            if (! $state) {
                return null;
            }

            return $state;
        });

        $this->registerListeners([]);

        $this->registerActions($this->getActionsToRegister());
    }

    public function getActionsToRegister(): array
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
            ->map(function ($action) {
                return fn (): Action => $action::make(class_basename($action));
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

    public function getMergeTags(): ?array
    {
        return $this->evaluate($this->mergeTags) ?? [];
    }

    public function relativePaths(array | Closure $relativePaths): static
    {
        $this->relativePaths = $relativePaths;

        return $this;
    }

    public function useRelativePaths(): bool
    {
        return $this->evaluate($this->relativePaths) ?? false;
    }
}
