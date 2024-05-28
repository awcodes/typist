<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class AlignEnd extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-align-end')
            ->iconButton()
            ->command(name: 'setTextAlign', attributes: 'end')
            ->active(attributes: ['textAlign' => 'end']);
    }
}
