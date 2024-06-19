<?php

namespace Awcodes\Typist\Actions;

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
            ->label(trans('typist::typist.grid'))
            ->icon('typist-grid')
            ->iconButton()
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
                            ->label('Columns')
                            ->required()
                            ->live()
                            ->minValue(2)
                            ->maxValue(12)
                            ->numeric()
                            ->step(1),
                        Components\Select::make('stack_at')
                            ->label('Stack at')
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
                            ->label('Asymmetric')
                            ->default(false)
                            ->live()
                            ->columnSpanFull(),
                        Components\TextInput::make('left_span')
                            ->label('Left column span')
                            ->required()
                            ->live()
                            ->minValue(1)
                            ->maxValue(12)
                            ->numeric()
                            ->visible(fn (Get $get) => $get('asymmetric')),
                        Components\TextInput::make('right_span')
                            ->label('Right column span')
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
                $data = Js::from($data);
                $component->getLivewire()->js(<<<JS
                    window.editors['$statePath'].chain().focus().insertGrid($data).run()
                JS);
            })
            ->after(function (TypistEditor $component): void {
                $component->getLivewire()->dispatch('focus-editor', statePath: $component->getStatePath());
            })
            ->active('grid');
    }
}
