<?php

namespace Awcodes\Typist\Support;

use Filament\Actions\ActionGroup;
use Filament\Actions\StaticAction;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\IconPosition;

class SuggestionGroup extends ActionGroup
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->color('gray')
            ->size(ActionSize::Small)
            ->button();
    }

    /**
     * @param  array<StaticAction | ActionGroup>  $actions
     */
    public static function make(array $actions): static
    {
        foreach ($actions as $action) {
            $action->grouped();
        }

        $static = app(static::class, ['actions' => $actions]);
        $static->configure();

        return $static;
    }
}
