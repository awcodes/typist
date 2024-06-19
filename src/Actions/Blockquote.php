<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Blockquote extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.blockquote'))
            ->icon(icon: 'typist-blockquote')
            ->iconButton()
            ->command(name: 'toggleBlockquote')
            ->active(name: 'blockquote');
    }
}
