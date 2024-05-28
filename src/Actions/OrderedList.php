<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class OrderedList extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-list-ordered')
            ->iconButton()
            ->command(name: 'toggleOrderedList')
            ->active(name: 'unorderedList');
    }
}
