<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class RemoveMedia extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-trash')
            ->iconButton()
            ->command(name: 'deleteSelection');
    }
}
