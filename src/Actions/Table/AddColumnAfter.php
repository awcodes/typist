<?php

namespace Awcodes\Typist\Actions\Table;

use Awcodes\Typist\TypistAction;

class AddColumnAfter extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.table_add_column_after'))
            ->icon(icon: 'typist-table-add-column-after')
            ->iconButton()
            ->active(false)
            ->command(name: 'addColumnAfter');
    }
}
