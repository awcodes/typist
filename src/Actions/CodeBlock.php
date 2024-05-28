<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class CodeBlock extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-code-block')
            ->iconButton()
            ->command(name: 'toggleCodeBlock')
            ->active(name: 'codeBlock');
    }
}
