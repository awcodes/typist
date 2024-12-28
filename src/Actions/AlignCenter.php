<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\Tiptap\Extensions\TextAlign;
use Awcodes\Typist\TypistAction;

class AlignCenter extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.align.center'))
            ->icon(icon: 'typist-align-center')
            ->iconButton()
            ->command(name: 'setTextAlign', attributes: 'center')
            ->active(attributes: ['textAlign' => 'center'])
            ->jsExtension('TextAlign')
            ->converterExtensions(new TextAlign(['types' => ['heading', 'paragraph']]));
    }
}
