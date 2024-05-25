<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;

class HeadingThree extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-heading-three')
            ->iconButton()
            ->alpineClickHandler("handleAction('toggleHeading', {level: 3}); close()")
            ->visible(function (TypistEditor $component) {
                return in_array(3, $component->getHeadingLevels());
            })
            ->active(name: 'heading', attributes: ['level' => 3]);
    }
}
