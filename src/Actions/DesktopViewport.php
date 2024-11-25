<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class DesktopViewport extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.desktop_viewport'))
            ->icon(icon: 'typist-desktop')
            ->iconButton()
            ->alpineClickHandler('toggleViewport("desktop")')
            ->extraAttributes([
                'x-show' => 'fullscreen',
            ]);
    }
}
