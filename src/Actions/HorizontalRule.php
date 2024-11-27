<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Tiptap\Nodes\HorizontalRule as HorizontalRuleExtension;

class HorizontalRule extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.horizontal_rule'))
            ->icon(icon: 'typist-hr')
            ->iconButton()
            ->command(name: 'setHorizontalRule')
            ->converterExtensions(new HorizontalRuleExtension);
    }
}
