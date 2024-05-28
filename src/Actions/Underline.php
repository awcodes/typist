<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Underline extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-underline')
            ->iconButton()
            ->command(name: 'toggleUnderline')
            ->active(name: 'underline');
    }
}
