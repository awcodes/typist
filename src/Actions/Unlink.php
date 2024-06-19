<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;

class Unlink extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.unlink'))
            ->icon(icon: 'typist-unlink')
            ->iconButton()
            ->alpineClickHandler(function (TypistEditor $component) {
                $statePath = $component->getStatePath();

                return "window.editors['$statePath'].chain().extendMarkRange('link').unsetLink().selectTextblockEnd().run()";
            });
    }
}
