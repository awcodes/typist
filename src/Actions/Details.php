<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Details extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-details')
            ->iconButton()
            ->alpineClickHandler("handleAction('setDetails')")
            ->active('details');
    }
}
