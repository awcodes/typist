<?php

namespace Awcodes\Typist\Concerns;

use Awcodes\Typist\Actions;
use Awcodes\Typist\Support\ToolbarGroup;
use Closure;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Actions\Action;

trait HasToolbar
{
    protected array | Closure | null $toolbar = null;

    protected bool | Closure | null $mergeToolbarActions = null;

    /**
     * @param  array<ToolbarGroup|Action> | Closure  $actions
     */
    public function toolbar(array | Closure $actions, bool | Closure $merge = true): static
    {
        $this->toolbar = $actions;
        $this->mergeToolbarActions = $merge;

        return $this;
    }

    public function getToolbarActions(): array
    {
        $flatActions = [];

        collect($this->getToolbar())->each(function ($action) use (&$flatActions) {
            if (is_subclass_of($action, ActionGroup::class)) {
                foreach ($action->getActions() as $action) {
                    $flatActions[] = $action;
                }
            } else {
                $flatActions[] = $action;
            }
        });

        return $flatActions;
    }

    /**
     * @return array<ToolbarGroup|Action>
     */
    public function getToolbar(): array
    {
        if ($this->evaluate($this->mergeToolbarActions)) {
            return [
                ...$this->getDefaultToolbarActions(),
                ...$this->evaluate($this->toolbar),
            ];
        }

        return $this->evaluate($this->toolbar) ?? $this->getDefaultToolbarActions();
    }

    public function getDefaultToolbarActions(): array
    {
        return [
            ToolbarGroup::make([
                Actions\Paragraph::make('toolbarParagraph'),
                Actions\HeadingOne::make('toolbarHeadingOne'),
                Actions\HeadingTwo::make('toolbarHeadingTwo'),
                Actions\HeadingThree::make('toolbarHeadingThree'),
                Actions\HeadingFour::make('toolbarHeadingFour'),
                Actions\HeadingFive::make('toolbarHeadingFive'),
                Actions\HeadingSix::make('toolbarHeadingSix'),
            ]),
            Actions\Bold::make('toolbarBold'),
            Actions\Italic::make('toolbarItalic'),
            Actions\Strike::make('toolbarStrike'),
            Actions\Underline::make('toolbarUnderline'),
            Actions\Link::make('toolbarLink'),
            Actions\Media::make('toolbarMedia'),
            Actions\BulletList::make('toolbarBulletList'),
            Actions\OrderedList::make('toolbarOrderedList'),
            Actions\Blockquote::make('toolbarBlockquote'),
            Actions\HorizontalRule::make('toolbarHorizontalRule'),
            Actions\Code::make('toolbarCode'),
            Actions\CodeBlock::make('toolbarCodeBlock'),
            Actions\Details::make('toolbarDetails'),
            Actions\Grid::make('toolbarGrid'),
            Actions\Table::make('toolbarTable'),
            Actions\AlignStart::make('toolbarAlignStart'),
            Actions\AlignCenter::make('toolbarAlignCenter'),
            Actions\AlignEnd::make('toolbarAlignEnd'),
            Actions\AlignJustify::make('toolbarAlignJustify'),
        ];
    }
}
