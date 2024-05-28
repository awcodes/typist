<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class AlignJustify extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-align-justify')
            ->iconButton()
            ->command(name: 'setTextAlign', attributes: 'justify')
            ->active(attributes: ['textAlign' => 'justify']);
    }
}
