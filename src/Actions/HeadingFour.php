<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;

class HeadingFour extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-heading-four')
            ->iconButton()
            ->command(name: 'toggleHeading', attributes: ['level' => 4])
            ->close()
            ->visible(function (TypistEditor $component) {
                return in_array(4, $component->getHeadingLevels());
            })
            ->active(name: 'heading', attributes: ['level' => 4]);
    }
}
