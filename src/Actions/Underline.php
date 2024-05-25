<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Underline extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-underline')
            ->iconButton()
            ->alpineClickHandler("handleAction('toggleUnderline')")
            ->active('underline');
    }
}
