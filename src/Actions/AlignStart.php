<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\Tiptap\Extensions\TextAlign;
use Awcodes\Typist\TypistAction;

class AlignStart extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.align_start'))
            ->icon(icon: 'typist-align-start')
            ->iconButton()
            ->command(name: 'setTextAlign', attributes: 'start')
            ->jsExtension('TextAlign')
            ->converterExtensions(new TextAlign(['types' => ['heading', 'paragraph']]));
    }
}
