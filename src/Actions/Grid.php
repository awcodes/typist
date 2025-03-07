<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\Tiptap\Nodes\Grid as GridExtension;
use Awcodes\Typist\Tiptap\Nodes\GridColumn as GridColumnExtension;
use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;
use Filament\Forms\Components;
use Filament\Forms\Get;
use Illuminate\Support\Js;

class Grid extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.grid.label'))
            ->icon('typist-grid')
            ->iconButton()
            ->active('grid')
            ->converterExtensions([
                new GridExtension,
                new GridColumnExtension,
            ])
            ->fillForm([
                'columns' => 2,
                'stack_at' => 'md',
                'asymmetric' => false,
            ])
            ->form([
                Components\Grid::make(2)
                    ->schema([
                        Components\View::make('typist::components.grid-preview')
                            ->columnSpanFull(),
                        Components\TextInput::make('columns')
                            ->label(fn () => trans('typist::typist.grid.columns'))
                            ->required()
                            ->live()
                            ->minValue(2)
                            ->maxValue(12)
                            ->numeric()
                            ->step(1),
                        Components\Select::make('stack_at')
                            ->label(fn () => trans('typist::typist.grid.stack_at'))
                            ->live()
                            ->selectablePlaceholder(false)
                            ->options([
                                'none' => 'Don\'t Stack',
                                'sm' => 'sm',
                                'md' => 'md',
                                'lg' => 'lg',
                            ])
                            ->default('md'),
                        Components\Toggle::make('asymmetric')
                            ->label(fn () => trans('typist::typist.grid.asymmetric'))
                            ->default(false)
                            ->live()
                            ->columnSpanFull(),
                        Components\TextInput::make('left_span')
                            ->label(fn () => trans('typist::typist.grid.left_span'))
                            ->required()
                            ->live()
                            ->minValue(1)
                            ->maxValue(12)
                            ->numeric()
                            ->visible(fn (Get $get) => $get('asymmetric')),
                        Components\TextInput::make('right_span')
                            ->label(fn () => trans('typist::typist.grid.right_span'))
                            ->required()
                            ->live()
                            ->minValue(1)
                            ->maxValue(12)
                            ->numeric()
                            ->visible(fn (Get $get) => $get('asymmetric')),
                    ]),
            ])
            ->action(function (TypistEditor $component, array $arguments, array $data): void {
                $statePath = $component->getStatePath();

                $data['coordinates'] = [
                    'from' => $arguments['coordinates']['anchor'] ?? 1,
                    'to' => $arguments['coordinates']['head'] ?? 1,
                ];

                $data = Js::from($data);

                $component->getLivewire()->js(<<<JS
                    Alpine.nextTick(() => {
                        window.editors['$statePath'].chain().focus().insertGrid($data).run()
                    })
                JS);
            })
            ->after(function (TypistEditor $component): void {
                $component->getLivewire()->dispatch('focus-editor', statePath: $component->getStatePath());
            });
    }
}
