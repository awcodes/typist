<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class AlignEnd extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-align-end')
            ->iconButton()
            ->alpineClickHandler("handleAction('setTextAlign', 'end')")
            ->active(attributes: ['textAlign' => 'end']);
    }
}
