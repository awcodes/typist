<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Code extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.code'))
            ->icon(icon: 'typist-code')
            ->iconButton()
            ->command(name: 'toggleCode')
            ->active(name: 'code');
    }
}
