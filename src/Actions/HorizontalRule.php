<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;

class HorizontalRule extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-hr')
            ->iconButton()
            ->alpineClickHandler("handleAction('setHorizontalRule')");
    }
}
