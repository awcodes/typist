<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class RemoveMedia extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.remove_media'))
            ->icon(icon: 'typist-trash')
            ->iconButton()
            ->command(name: 'deleteSelection');
    }
}
