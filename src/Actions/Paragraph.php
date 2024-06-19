<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Paragraph extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.paragraph'))
            ->icon(icon: 'typist-paragraph')
            ->iconButton()
            ->command(name: 'setParagraph')
            ->active(name: 'paragraph');
    }
}
