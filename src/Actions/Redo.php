<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Redo extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.redo'))
            ->icon(icon: 'typist-redo')
            ->iconButton()
            ->command(name: 'redo');
    }
}
