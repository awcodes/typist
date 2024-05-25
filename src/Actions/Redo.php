<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Redo extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-redo')
            ->iconButton()
            ->alpineClickHandler("handleAction('redo')");
    }
}
