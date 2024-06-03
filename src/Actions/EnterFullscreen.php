<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class EnterFullscreen extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-fullscreen-enter')
            ->iconButton()
            ->alpineClickHandler('fullscreen = ! fullscreen')
            ->extraAttributes([
                'x-show' => '! fullscreen',
            ]);
    }
}
