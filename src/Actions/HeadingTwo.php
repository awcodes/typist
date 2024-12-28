<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;
use Tiptap\Nodes\Heading as HeadingExtension;

class HeadingTwo extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.heading.two'))
            ->icon(icon: 'typist-heading-two')
            ->iconButton()
            ->command(name: 'toggleHeading', attributes: ['level' => 2])
            ->visible(function (TypistEditor $component) {
                return in_array(2, $component->getHeadingLevels());
            })
            ->active(name: 'heading', attributes: ['level' => 2])
            ->jsExtension('Heading')
            ->converterExtensions(new HeadingExtension);
    }
}
