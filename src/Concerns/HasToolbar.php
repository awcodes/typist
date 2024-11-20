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
                Actions\Paragraph::make('Paragraph'),
                Actions\HeadingOne::make('HeadingOne'),
                Actions\HeadingTwo::make('HeadingTwo'),
                Actions\HeadingThree::make('HeadingThree'),
                Actions\HeadingFour::make('HeadingFour'),
                Actions\HeadingFive::make('HeadingFive'),
                Actions\HeadingSix::make('HeadingSix'),
            ]),
            ToolbarGroup::make([
                Actions\Bold::make('Bold'),
                Actions\Italic::make('Italic'),
                Actions\Strike::make('Strike'),
                Actions\Underline::make('Underline'),
                Actions\Lead::make('Lead'),
                Actions\Small::make('Small'),
            ])->label('Styling'),
            ToolbarGroup::make([
                Actions\Link::make('Link'),
                Actions\Media::make('Media'),
                Actions\BulletList::make('BulletList'),
                Actions\OrderedList::make('OrderedList'),
                Actions\Blockquote::make('Blockquote'),
                Actions\HorizontalRule::make('HorizontalRule'),
                Actions\Code::make('Code'),
                Actions\CodeBlock::make('CodeBlock'),
                Actions\Details::make('Details'),
                Actions\Grid::make('Grid'),
                Actions\Table::make('Table'),
            ])->label('Elements'),
            ToolbarGroup::make([
                Actions\AlignStart::make('AlignStart'),
                Actions\AlignCenter::make('AlignCenter'),
                Actions\AlignEnd::make('AlignEnd'),
                Actions\AlignJustify::make('AlignJustify'),
            ])->label('Align'),
        ];
    }
}
