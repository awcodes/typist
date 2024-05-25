<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class AlignCenter extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-align-center')
            ->iconButton()
            ->alpineClickHandler("handleAction('setTextAlign', 'center')")
            ->active(attributes: ['textAlign' => 'center']);
    }
}
