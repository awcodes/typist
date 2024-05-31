<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Bold extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-bold')
            ->iconButton()
            ->command(name: 'toggleBold')
            ->active(name: 'bold');
    }
}
