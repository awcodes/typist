<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class ClearContent extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-erase')
            ->iconButton()
            ->alpineClickHandler("handleAction('clearContent', true)");
    }
}
