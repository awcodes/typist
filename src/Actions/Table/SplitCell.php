<?php

namespace Awcodes\Typist\Actions\Table;

use Awcodes\Typist\TypistAction;

class SplitCell extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.table.split_cell'))
            ->icon(icon: 'typist-table-split-cell')
            ->iconButton()
            ->active(false)
            ->command(name: 'splitCell');
    }
}
