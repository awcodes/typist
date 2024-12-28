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
            ->label(fn () => trans('typist::typist.link.label'))
            ->icon('typist-link')
            ->iconButton()
            ->active('link')
            ->converterExtensions(new LinkExtension)
            ->form([
                Components\Grid::make(['md' => 3])
                    ->schema([
                        Components\TextInput::make('href')
                            ->label(fn () => trans('typist::typist.link.href'))
                            ->columnSpan('full')
                            ->requiredWithout('id')
                            ->validationAttribute('URL'),
                        Components\TextInput::make('id')
                            ->label(fn () => trans('typist::typist.link.id')),
                        Components\Select::make('target')
                            ->label(fn () => trans('typist::typist.link.target.label'))
                            ->selectablePlaceholder(false)
                            ->options([
                                '' => trans('typist::typist.link.target.self'),
                                '_blank' => trans('typist::typist.link.target.new_window'),
                                '_parent' => trans('typist::typist.link.target.parent'),
                                '_top' => trans('typist::typist.link.target.top'),
                            ]),
                        Components\TextInput::make('hreflang')
                            ->label(fn () => trans('typist::typist.link.hreflang')),
                        Components\TextInput::make('rel')
                            ->label(fn () => trans('typist::typist.link.rel'))
                            ->columnSpan('full'),
                        Components\TextInput::make('referrerpolicy')
                            ->label(fn () => trans('typist::typist.link.referrerpolicy'))
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
