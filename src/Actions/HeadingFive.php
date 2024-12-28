<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;
use Tiptap\Nodes\Heading as HeadingExtension;

class HeadingFive extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.heading.five'))
            ->icon(icon: 'typist-heading-five')
            ->iconButton()
            ->command(name: 'toggleHeading', attributes: ['level' => 5])
            ->visible(function (TypistEditor $component) {
                return in_array(5, $component->getHeadingLevels());
            })
            ->active(name: 'heading', attributes: ['level' => 5])
            ->jsExtension('Heading')
            ->converterExtensions(new HeadingExtension);
    }
}
