<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;

class HeadingOne extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-heading-one')
            ->iconButton()
            ->alpineClickHandler("handleAction('toggleHeading', {level: 1}); close()")
            ->visible(function (TypistEditor $component) {
                return in_array(1, $component->getHeadingLevels());
            })
            ->active(name: 'heading', attributes: ['level' => 1]);
    }
}
