<?php

namespace Awcodes\Typist\Actions\Table;

use Awcodes\Typist\TypistAction;

class DeleteTable extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.table.delete'))
            ->icon(icon: 'typist-table-delete')
            ->iconButton()
            ->active(false)
            ->command(name: 'deleteTable');
    }
}
