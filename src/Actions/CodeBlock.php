<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Tiptap\Nodes\CodeBlockHighlight as CodeBlockExtension;

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
            ->active(name: 'codeBlock')
            ->converterExtensions(new CodeBlockExtension([
                'languageClassPrefix' => 'language-',
            ]));
    }
}
