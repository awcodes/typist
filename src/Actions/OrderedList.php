<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class OrderedList extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-list-ordered')
            ->iconButton()
            ->alpineClickHandler("handleAction('toggleOrderedList')")
            ->active('unorderedList');
    }
}
