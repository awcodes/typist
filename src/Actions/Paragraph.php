<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Paragraph extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-paragraph')
            ->iconButton()
            ->alpineClickHandler("handleAction('setParagraph'); close()")
            ->active('paragraph');
    }
}
