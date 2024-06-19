<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Strike extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.strike'))
            ->icon(icon: 'typist-strike')
            ->iconButton()
            ->command(name: 'toggleStrike')
            ->active(name: 'strike');
    }
}
