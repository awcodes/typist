<?php

namespace Awcodes\Typist\Concerns;

use Awcodes\Typist\Facades\Typist;
use Awcodes\Typist\Support\ToolbarGroup;
use Closure;
use Filament\Forms\Components\Actions\Action;

trait HasToolbar
{
    protected array | Closure | null $toolbar = null;

    /**
     * @param  array<ToolbarGroup|Action> | Closure  $actions
     */
    public function toolbar(array | Closure $actions): static
    {
        $this->toolbar = $actions;

        return $this;
    }

    /**
     * @return array<ToolbarGroup|Action>
     */
    public function getToolbar(): array
    {
        return $this->evaluate($this->toolbar) ?? [
            ToolbarGroup::make([
                Typist::getAction('Paragraph'),
                Typist::getAction('HeadingOne'),
                Typist::getAction('HeadingTwo'),
                Typist::getAction('HeadingThree'),
                Typist::getAction('HeadingFour'),
                Typist::getAction('HeadingFive'),
                Typist::getAction('HeadingSix'),
            ]),
            Typist::getAction('Bold'),
            Typist::getAction('Italic'),
            Typist::getAction('Strike'),
            Typist::getAction('Underline'),
            Typist::getAction('Link'),
            Typist::getAction('Media'),
            Typist::getAction('BulletList'),
            Typist::getAction('OrderedList'),
            Typist::getAction('Blockquote'),
            Typist::getAction('HorizontalRule'),
            Typist::getAction('CodeBlock'),
            Typist::getAction('Code'),
            Typist::getAction('Details'),
            Typist::getAction('Grid'),
            Typist::getAction('AlignStart'),
            Typist::getAction('AlignCenter'),
            Typist::getAction('AlignEnd'),
            Typist::getAction('Alert'),
        ];
    }
}
