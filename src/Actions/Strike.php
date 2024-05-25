<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Strike extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-strike')
            ->iconButton()
            ->alpineClickHandler("handleAction('toggleStrike')")
            ->active('strike');
    }
}
