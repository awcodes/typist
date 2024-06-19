<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Bold extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.bold'))
            ->icon(icon: 'typist-bold')
            ->iconButton()
            ->command(name: 'toggleBold')
            ->active(name: 'bold');
    }
}
