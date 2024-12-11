<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Tiptap\Marks\Strike as StrikeExtension;

class Strike extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.strike'))
            ->icon(icon: 'typist-strike')
            ->iconButton()
            ->command(name: 'toggleStrike')
            ->active(name: 'strike')
            ->converterExtensions(new StrikeExtension);
    }
}
