<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class ExitFullscreen extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-fullscreen-exit')
            ->iconButton()
            ->alpineClickHandler('fullscreen = ! fullscreen')
            ->extraAttributes([
                'x-show' => 'fullscreen',
            ]);
    }
}
