<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Undo extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-undo')
            ->iconButton()
            ->alpineClickHandler("handleAction('undo')");
    }
}
