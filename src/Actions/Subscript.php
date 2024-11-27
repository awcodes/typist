<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Tiptap\Marks\Subscript as SubscriptExtension;

class Subscript extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.subscript'))
            ->icon(icon: 'typist-subscript')
            ->iconButton()
            ->command(name: 'toggleSubscript')
            ->active(name: 'subscript')
            ->converterExtensions(new SubscriptExtension);
    }
}
