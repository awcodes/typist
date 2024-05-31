<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;

class HeadingSix extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-heading-six')
            ->iconButton()
            ->command(name: 'toggleHeading', attributes: ['level' => 6])
            ->close()
            ->visible(function (TypistEditor $component) {
                return in_array(6, $component->getHeadingLevels());
            })
            ->active(name: 'heading', attributes: ['level' => 6]);
    }
}
