<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class EnterFullscreen extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.enter_fullscreen'))
            ->icon(icon: 'typist-fullscreen-enter')
            ->iconButton()
            ->alpineClickHandler('toggleFullscreen($event)')
            ->extraAttributes([
                'x-show' => '! fullscreen',
            ]);
    }
}
