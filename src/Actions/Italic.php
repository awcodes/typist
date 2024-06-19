<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Italic extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.italic'))
            ->icon(icon: 'typist-italic')
            ->iconButton()
            ->command(name: 'toggleItalic')
            ->active(name: 'italic');
    }
}
