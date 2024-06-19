<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class CodeBlock extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.code_block'))
            ->icon(icon: 'typist-code-block')
            ->iconButton()
            ->command(name: 'toggleCodeBlock')
            ->active(name: 'codeBlock');
    }
}
