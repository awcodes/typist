<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Tiptap\Marks\Bold as BoldExtension;

class Bold extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.bold'))
            ->icon(icon: 'typist-bold')
            ->iconButton()
            ->command(name: 'toggleBold')
            ->active(name: 'bold')
            ->converterExtensions(new BoldExtension);
    }
}
