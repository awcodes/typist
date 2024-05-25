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
            ->icon('typist-heading-six')
            ->iconButton()
            ->alpineClickHandler("handleAction('toggleHeading', {level: 6}); close()")
            ->visible(function (TypistEditor $component) {
                return in_array(6, $component->getHeadingLevels());
            })
            ->active(name: 'heading', attributes: ['level' => 6]);
    }
}
