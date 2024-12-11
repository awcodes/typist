<?php

namespace Awcodes\Typist\Actions\Table;

use Awcodes\Typist\TypistAction;

class AddColumnBefore extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.table_add_column_before'))
            ->icon(icon: 'typist-table-add-column-before')
            ->iconButton()
            ->active(false)
            ->command(name: 'addColumnBefore');
    }
}
