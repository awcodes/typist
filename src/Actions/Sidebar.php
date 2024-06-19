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
            ->label(trans('typist::typist.sidebar'))
            ->icon(icon: 'typist-sidebar')
            ->iconButton()
            ->alpineClickHandler('toggleSidebar($event)')
            ->visible(function (TypistEditor $component) {
                return (! $component->isSidebarHidden()) &&
                (! $component->isDisabled()) && (filled($component->getMergeTags()) || filled($component->getSidebarActions()));
            });
    }
}
