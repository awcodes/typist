<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;

class HeadingOne extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.heading_one'))
            ->icon(icon: 'typist-heading-one')
            ->iconButton()
            ->command(name: 'toggleHeading', attributes: ['level' => 1])
            ->close()
            ->visible(function (TypistEditor $component) {
                return in_array(1, $component->getHeadingLevels());
            })
            ->active(name: 'heading', attributes: ['level' => 1]);
    }
}
