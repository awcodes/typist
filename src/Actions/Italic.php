<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Tiptap\Marks\Italic as ItalicExtension;

class Italic extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.italic'))
            ->icon(icon: 'typist-italic')
            ->iconButton()
            ->command(name: 'toggleItalic')
            ->active(name: 'italic')
            ->converterExtensions(new ItalicExtension);
    }
}
