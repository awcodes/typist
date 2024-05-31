<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class ClearContent extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-erase')
            ->iconButton()
            ->command(name: 'clearContent', attributes: true);
    }
}
