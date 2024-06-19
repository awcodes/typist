<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class ExitFullscreen extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.exit_fullscreen'))
            ->icon(icon: 'typist-fullscreen-exit')
            ->iconButton()
            ->alpineClickHandler('toggleFullscreen($event)')
            ->extraAttributes([
                'x-show' => 'fullscreen',
            ]);
    }
}
