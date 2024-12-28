<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;
use Filament\Forms\Components;
use Filament\Forms\Get;
use Illuminate\Support\Js;
use Tiptap\Nodes\Table as TableExtension;
use Tiptap\Nodes\TableCell;
use Tiptap\Nodes\TableHeader;
use Tiptap\Nodes\TableRow;

class Table extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.table.label'))
            ->icon('typist-table')
            ->iconButton()
            ->active('table')
            ->converterExtensions([
                new TableExtension,
                new TableRow,
                new TableCell,
                new TableHeader,
            ])
            ->fillForm([
                'rows' => 2,
                'cols' => 3,
                'withHeaderRow' => true,
            ])
            ->form([
                Components\TextInput::make('rows')
                    ->label(fn () => trans('typist::typist.table.rows'))
                    ->numeric()
                    ->required()
                    ->dehydrateStateUsing(function (Get $get, $state) {
                        if ($get('withHeaderRow')) {
                            return $state + 1;
                        }

                        return $state;
                    }),
                Components\TextInput::make('cols')
                    ->label(fn () => trans('typist::typist.table.columns'))
                    ->numeric()
                    ->required(),
                Components\Checkbox::make('withHeaderRow')
                    ->label(fn () => trans('typist::typist.table.header_row')),
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
            });
    }
}
