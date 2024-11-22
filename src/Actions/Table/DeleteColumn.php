<?php

namespace Awcodes\Typist\Actions\Table;

use Awcodes\Typist\TypistAction;

class DeleteColumn extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.table_delete_column'))
            ->icon(icon: 'typist-table-delete-column')
            ->iconButton()
            ->active(false)
            ->command(name: 'deleteColumn');
    }
}
