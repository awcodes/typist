<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\Tiptap\Marks\Small as SmallExtension;
use Awcodes\Typist\TypistAction;

class Small extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.small'))
            ->icon(icon: 'typist-small')
            ->iconButton()
            ->command(name: 'toggleSmall')
            ->active(name: 'small')
            ->converterExtensions(new SmallExtension);
    }
}
