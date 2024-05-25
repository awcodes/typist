<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class AlignStart extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-align-start')
            ->iconButton()
            ->alpineClickHandler("handleAction('setTextAlign', 'start')");
    }
}
