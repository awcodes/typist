<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class BulletList extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-list-unordered')
            ->iconButton()
            ->alpineClickHandler("handleAction('toggleBulletList')")
            ->active('bulletList');
    }
}
