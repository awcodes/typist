<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class AlignCenter extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.align_center'))
            ->icon(icon: 'typist-align-center')
            ->iconButton()
            ->command(name: 'setTextAlign', attributes: 'center')
            ->active(attributes: ['textAlign' => 'center']);
    }
}
