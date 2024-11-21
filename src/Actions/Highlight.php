<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Highlight extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.highlight'))
            ->icon(icon: 'typist-highlight')
            ->iconButton()
            ->command(name: 'toggleHighlight')
            ->active(name: 'highlight');
    }
}
