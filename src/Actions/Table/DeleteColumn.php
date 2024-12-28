<?php

namespace Awcodes\Typist\Actions\Table;

use Awcodes\Typist\TypistAction;

class DeleteColumn extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.table.delete_column'))
            ->icon(icon: 'typist-table-delete-column')
            ->iconButton()
            ->active(false)
            ->command(name: 'deleteColumn');
    }
}
