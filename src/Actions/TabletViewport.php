<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class TabletViewport extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.tablet_viewport'))
            ->icon(icon: 'typist-tablet')
            ->iconButton()
            ->alpineClickHandler('toggleViewport("tablet")')
            ->extraAttributes([
                'x-show' => 'fullscreen',
            ]);
    }
}
