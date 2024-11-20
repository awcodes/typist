<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Small extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.small'))
            ->icon(icon: 'typist-small')
            ->iconButton()
            ->command(name: 'toggleSmall')
            ->active(name: 'small');
    }
}
