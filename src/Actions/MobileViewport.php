<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class MobileViewport extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.mobile_viewport'))
            ->icon(icon: 'typist-mobile')
            ->iconButton()
            ->alpineClickHandler('toggleViewport("mobile")')
            ->extraAttributes([
                'x-show' => 'fullscreen',
            ]);
    }
}
