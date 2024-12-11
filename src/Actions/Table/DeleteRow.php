<?php

namespace Awcodes\Typist\Actions\Table;

use Awcodes\Typist\TypistAction;

class DeleteRow extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.table_delete_row'))
            ->icon(icon: 'typist-table-delete-row')
            ->iconButton()
            ->active(false)
            ->command(name: 'deleteRow');
    }
}
