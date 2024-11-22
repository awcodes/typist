<?php

namespace Awcodes\Typist\Actions\Table;

use Awcodes\Typist\TypistAction;

class DeleteTable extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.table_delete'))
            ->icon(icon: 'typist-table-delete')
            ->iconButton()
            ->active(false)
            ->command(name: 'deleteTable');
    }
}
