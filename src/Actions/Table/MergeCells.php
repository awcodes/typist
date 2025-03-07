<?php

namespace Awcodes\Typist\Actions\Table;

use Awcodes\Typist\TypistAction;

class MergeCells extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.table.merge_cells'))
            ->icon(icon: 'typist-table-merge-cells')
            ->iconButton()
            ->active(false)
            ->command(name: 'mergeCells');
    }
}
