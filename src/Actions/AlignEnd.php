<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\Tiptap\Extensions\TextAlign;
use Awcodes\Typist\TypistAction;

class AlignEnd extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.align_end'))
            ->icon(icon: 'typist-align-end')
            ->iconButton()
            ->command(name: 'setTextAlign', attributes: 'end')
            ->active(attributes: ['textAlign' => 'end'])
            ->jsExtension('TextAlign')
            ->converterExtensions(new TextAlign(['types' => ['heading', 'paragraph']]));
    }
}
