<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Tiptap\Nodes\OrderedList as OrderedListExtension;

class OrderedList extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.ordered_list'))
            ->icon(icon: 'typist-list-ordered')
            ->iconButton()
            ->command(name: 'toggleOrderedList')
            ->active(name: 'unorderedList')
            ->converterExtensions(new OrderedListExtension);
    }
}
