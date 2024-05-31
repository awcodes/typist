<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Paragraph extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-paragraph')
            ->iconButton()
            ->command(name: 'setParagraph')
            ->active(name: 'paragraph');
    }
}
