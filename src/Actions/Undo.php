<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Undo extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.undo'))
            ->icon(icon: 'typist-undo')
            ->iconButton()
            ->command(name: 'undo');
    }
}
