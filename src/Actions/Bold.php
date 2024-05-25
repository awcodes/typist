<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Bold extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-bold')
            ->iconButton()
            ->alpineClickHandler("handleAction('toggleBold')")
            ->active('bold');
    }
}
