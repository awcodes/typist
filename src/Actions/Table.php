<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;
use Filament\Forms\Components;
use Filament\Forms\Get;
use Illuminate\Support\Js;

class Table extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.table'))
            ->icon('typist-table')
            ->iconButton()
            ->fillForm([
                'rows' => 2,
                'cols' => 3,
                'withHeaderRow' => true,
            ])
            ->form([
                Components\TextInput::make('rows')
                    ->label('Rows')
                    ->numeric()
                    ->required()
                    ->dehydrateStateUsing(function (Get $get, $state) {
                        if ($get('withHeaderRow')) {
                            return $state + 1;
                        }

                        return $state;
                    }),
                Components\TextInput::make('cols')
                    ->label('Columns')
                    ->numeric()
                    ->required(),
                Components\Checkbox::make('withHeaderRow'),
            ])
            ->action(function (TypistEditor $component, array $arguments, array $data): void {
                $statePath = $component->getStatePath();
                $data = Js::from($data);

                $component->getLivewire()->js(<<<JS
                    window.editors['$statePath'].chain().focus().insertTable($data).run()
                JS);
            })
            ->after(function (TypistEditor $component): void {
                $component->getLivewire()->dispatch('focus-editor', statePath: $component->getStatePath());
            })
            ->active('table');
    }
}
