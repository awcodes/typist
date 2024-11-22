<?php

namespace Awcodes\Typist\Actions\Table;

use Awcodes\Typist\TypistAction;

class AddRowBefore extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.table_add_row_before'))
            ->icon(icon: 'typist-table-add-row-before')
            ->iconButton()
            ->active(false)
            ->command(name: 'addRowBefore');
    }
}
