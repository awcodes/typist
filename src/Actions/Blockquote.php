<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Blockquote extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-blockquote')
            ->iconButton()
            ->command(name: 'toggleBlockquote')
            ->active(name: 'blockquote');
    }
}
