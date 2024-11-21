<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;
use Filament\Forms\Components\ColorPicker;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Js;

class Color extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.color'))
            ->icon(icon: 'typist-color')
            ->iconButton()
            ->modalWidth(MaxWidth::Small)
            ->form([
                ColorPicker::make('color'),
            ])
            ->action(function (TypistEditor $component, array $arguments, array $data): void {
                $statePath = $component->getStatePath();

                $color = $data['color'];
                $coords = Js::from([
                    'from' => $arguments['coordinates']['anchor'] ?? 1,
                    'to' => $arguments['coordinates']['head'] ?? $arguments['coordinates']['anchor'],
                ]);

                $component->getLivewire()->js(<<<JS
                    Alpine.nextTick(() => {
                        window.editors['$statePath'].chain().focus().setTextSelection($coords).setColor('$color').run()
                    })
                JS);
            });
    }
}
