<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;

class HeadingTwo extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.heading_two'))
            ->icon(icon: 'typist-heading-two')
            ->iconButton()
            ->command(name: 'toggleHeading', attributes: ['level' => 2])
            ->close()
            ->visible(function (TypistEditor $component) {
                return in_array(2, $component->getHeadingLevels());
            })
            ->active(name: 'heading', attributes: ['level' => 2]);
    }
}
