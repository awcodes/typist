<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Tiptap\Marks\Highlight as HighlightExtension;

class Highlight extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.highlight'))
            ->icon(icon: 'typist-highlight')
            ->iconButton()
            ->command(name: 'toggleHighlight')
            ->active(name: 'highlight')
            ->converterExtensions(new HighlightExtension);
    }
}
