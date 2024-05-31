<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class BulletList extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon(icon: 'typist-list-unordered')
            ->iconButton()
            ->command(name: 'toggleBulletList')
            ->active(name: 'bulletList');
    }
}
