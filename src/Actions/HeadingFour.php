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
            ->icon('typist-heading-four')
            ->iconButton()
            ->alpineClickHandler("handleAction('toggleHeading', {level: 4}); close()")
            ->visible(function (TypistEditor $component) {
                return in_array(4, $component->getHeadingLevels());
            })
            ->active(name: 'heading', attributes: ['level' => 4]);
    }
}
