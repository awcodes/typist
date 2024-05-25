<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class RemoveMedia extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-trash')
            ->iconButton()
            ->alpineClickHandler("handleAction('deleteSelection')");
    }
}
