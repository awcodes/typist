<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class Blockquote extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-blockquote')
            ->iconButton()
            ->alpineClickHandler("handleAction('toggleBlockquote')")
            ->active('blockquote');
    }
}
