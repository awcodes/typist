<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Undo extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-undo')
            ->iconButton()
            ->command(name: 'undo');
    }
}
