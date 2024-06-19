<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Details extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.details'))
            ->icon(icon: 'typist-details')
            ->iconButton()
            ->command(name: 'setDetails')
            ->active(name: 'details');
    }
}
