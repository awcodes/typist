<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;
use Tiptap\Nodes\Heading as HeadingExtension;

class HeadingOne extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.heading.one'))
            ->icon(icon: 'typist-heading-one')
            ->iconButton()
            ->command(name: 'toggleHeading', attributes: ['level' => 1])
            ->visible(function (TypistEditor $component) {
                return in_array(1, $component->getHeadingLevels());
            })
            ->active(name: 'heading', attributes: ['level' => 1])
            ->jsExtension('Heading')
            ->converterExtensions(new HeadingExtension);
    }
}
