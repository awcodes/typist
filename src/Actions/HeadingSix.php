<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;
use Tiptap\Nodes\Heading as HeadingExtension;

class HeadingSix extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.heading.six'))
            ->icon(icon: 'typist-heading-six')
            ->iconButton()
            ->command(name: 'toggleHeading', attributes: ['level' => 6])
            ->visible(function (TypistEditor $component) {
                return in_array(6, $component->getHeadingLevels());
            })
            ->active(name: 'heading', attributes: ['level' => 6])
            ->jsExtension('Heading')
            ->converterExtensions(new HeadingExtension);
    }
}
