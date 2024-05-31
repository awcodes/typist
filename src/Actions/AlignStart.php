<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class AlignStart extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-align-start')
            ->iconButton()
            ->command(name: 'setTextAlign', attributes: 'start');
    }
}
