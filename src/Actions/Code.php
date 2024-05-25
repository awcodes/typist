<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Code extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-code')
            ->iconButton()
            ->alpineClickHandler("handleAction('toggleCode')")
            ->active('code');
    }
}
