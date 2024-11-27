<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\Tiptap\Extensions\TextAlign;
use Awcodes\Typist\TypistAction;

class AlignJustify extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.align_justify'))
            ->icon(icon: 'typist-align-justify')
            ->iconButton()
            ->command(name: 'setTextAlign', attributes: 'justify')
            ->active(attributes: ['textAlign' => 'justify'])
            ->jsExtension('TextAlign')
            ->converterExtensions(new TextAlign(['types' => ['heading', 'paragraph']]));
    }
}
