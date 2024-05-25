<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Italic extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-italic')
            ->iconButton()
            ->alpineClickHandler('handleAction(\'toggleItalic\')')
            ->active('italic');
    }
}
