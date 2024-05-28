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
