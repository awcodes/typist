<?php

namespace Awcodes\Typist\Actions\Table;

use Awcodes\Typist\TypistAction;

class AddRowAfter extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.table_add_row_after'))
            ->icon(icon: 'typist-table-add-row-after')
            ->iconButton()
            ->active(false)
            ->command(name: 'addRowAfter');
    }
}
