<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Tiptap\Marks\Code as CodeExtension;

class Code extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.code'))
            ->icon(icon: 'typist-code')
            ->iconButton()
            ->command(name: 'toggleCode')
            ->active(name: 'code')
            ->converterExtensions(new CodeExtension);
    }
}
