<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\Tiptap\Nodes\Lead as LeadExtension;
use Awcodes\Typist\TypistAction;

class Lead extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.lead'))
            ->icon(icon: 'typist-lead')
            ->iconButton()
            ->command(name: 'toggleLead')
            ->active(name: 'lead')
            ->converterExtensions(new LeadExtension);
    }
}
