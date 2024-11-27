<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;
use Tiptap\Nodes\Heading as HeadingExtension;

class HeadingThree extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.heading_three'))
            ->icon(icon: 'typist-heading-three')
            ->iconButton()
            ->command(name: 'toggleHeading', attributes: ['level' => 3])
            ->visible(function (TypistEditor $component) {
                return in_array(3, $component->getHeadingLevels());
            })
            ->active(name: 'heading', attributes: ['level' => 3])
            ->jsExtension('Heading')
            ->converterExtensions(new HeadingExtension);
    }
}
