<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Tiptap\Marks\Underline as UnderlineExtension;

class Underline extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.underline'))
            ->icon(icon: 'typist-underline')
            ->iconButton()
            ->command(name: 'toggleUnderline')
            ->active(name: 'underline')
            ->converterExtensions(new UnderlineExtension);
    }
}
