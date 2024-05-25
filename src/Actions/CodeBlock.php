<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class CodeBlock extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-code-block')
            ->iconButton()
            ->alpineClickHandler("handleAction('toggleCodeBlock')")
            ->active('codeBlock');
    }
}
