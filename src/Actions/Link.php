<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\Tiptap\Marks\Link as LinkExtension;
use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;
use Filament\Forms\Components;
use Illuminate\Support\Js;

class Link extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.link'))
            ->icon('typist-link')
            ->iconButton()
            ->active('link')
            ->converterExtensions(new LinkExtension)
            ->form([
                Components\Grid::make(['md' => 3])
                    ->schema([
                        Components\TextInput::make('href')
                            ->columnSpan('full')
                            ->requiredWithout('id')
                            ->validationAttribute('URL'),
                        Components\TextInput::make('id'),
                        Components\Select::make('target')
                            ->selectablePlaceholder(false)
                            ->options([
                                '' => 'Self',
                                '_blank' => 'New Window',
                                '_parent' => 'Parent',
                                '_top' => 'Top',
                            ]),
                        Components\TextInput::make('hreflang'),
                        Components\TextInput::make('rel')
                            ->columnSpan('full'),
                        Components\TextInput::make('referrerpolicy')
                            ->columnSpan('full'),
                    ]),
            ])
            ->action(function (TypistEditor $component, array $arguments, array $data): void {
                $statePath = $component->getStatePath();

                $data = Js::from($data);

                $coords = Js::from([
                    'from' => $arguments['coordinates']['anchor'] ?? 1,
                    'to' => $arguments['coordinates']['head'] ?? 1,
                ]);

                $component->getLivewire()->js(<<<JS
                    Alpine.nextTick(() => {
                        window.editors['$statePath'].chain().focus().setTextSelection($coords).setLink($data).run()
                    })
                JS);
            })
            ->after(function (TypistEditor $component): void {
                $component->getLivewire()->dispatch('focus-editor', statePath: $component->getStatePath());
            });
    }
}
