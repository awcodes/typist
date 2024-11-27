<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Tiptap\Nodes\BulletList as BulletListExtension;

class BulletList extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.bullet_list'))
            ->icon(icon: 'typist-list-unordered')
            ->iconButton()
            ->command(name: 'toggleBulletList')
            ->active(name: 'bulletList')
            ->converterExtensions(new BulletListExtension);
    }
}
