<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class AlignJustify extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-align-justify')
            ->iconButton()
            ->alpineClickHandler("handleAction('setTextAlign', 'justify')")
            ->active(attributes: ['textAlign' => 'justify']);
    }
}
