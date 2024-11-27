<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;
use Tiptap\Nodes\Heading as HeadingExtension;

class HeadingFour extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.heading_four'))
            ->icon(icon: 'typist-heading-four')
            ->iconButton()
            ->command(name: 'toggleHeading', attributes: ['level' => 4])
            ->visible(function (TypistEditor $component) {
                return in_array(4, $component->getHeadingLevels());
            })
            ->active(name: 'heading', attributes: ['level' => 4])
            ->jsExtension('Heading')
            ->converterExtensions(new HeadingExtension);
    }
}
