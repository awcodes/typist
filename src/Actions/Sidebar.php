<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;

class Sidebar extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Toggle Sidebar')
            ->icon('typist-sidebar')
            ->iconButton()
            ->alpineClickHandler('toggleSidebar($event)')
            ->visible(function (TypistEditor $component) {
                return filled($component->getMergeTags());
            });
    }
}
