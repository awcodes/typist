<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\Tiptap\Nodes\Details as DetailsExtension;
use Awcodes\Typist\Tiptap\Nodes\DetailsContent as DetailsContentExtension;
use Awcodes\Typist\Tiptap\Nodes\DetailsSummary as DetailsSummaryExtension;
use Awcodes\Typist\TypistAction;

class Details extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.details'))
            ->icon(icon: 'typist-details')
            ->iconButton()
            ->command(name: 'setDetails')
            ->active(name: 'details')
            ->converterExtensions([
                new DetailsExtension,
                new DetailsContentExtension,
                new DetailsSummaryExtension,
            ]);
    }
}
