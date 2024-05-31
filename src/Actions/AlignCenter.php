<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class AlignCenter extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-align-center')
            ->iconButton()
            ->command(name: 'setTextAlign', attributes: 'center')
            ->active(attributes: ['textAlign' => 'center']);
    }
}
