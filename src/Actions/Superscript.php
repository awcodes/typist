<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Tiptap\Marks\Superscript as SuperscriptExtension;

class Superscript extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.superscript'))
            ->icon(icon: 'typist-superscript')
            ->iconButton()
            ->command(name: 'toggleSuperscript')
            ->active(name: 'superscript')
            ->converterExtensions(new SuperscriptExtension);
    }
}
