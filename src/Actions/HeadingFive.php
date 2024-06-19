<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;

class HeadingFive extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.heading_five'))
            ->icon(icon: 'typist-heading-five')
            ->iconButton()
            ->command(name: 'toggleHeading', attributes: ['level' => 5])
            ->close()
            ->visible(function (TypistEditor $component) {
                return in_array(5, $component->getHeadingLevels());
            })
            ->active(name: 'heading', attributes: ['level' => 5]);
    }
}
