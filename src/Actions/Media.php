<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\Tiptap\Nodes\Media as ImageExtension;
use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;
use Filament\Forms\Components;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Js;
use Illuminate\Support\Str;

class Media extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.media.label'))
            ->icon('typist-media')
            ->iconButton()
            ->active('media')
            ->converterExtensions(new ImageExtension)
            ->fillForm(function (TypistEditor $component, array $arguments) {
                $source = isset($arguments['src']) && $arguments['src'] !== ''
                    ? $component->getDirectory() . Str::of($arguments['src'])
                        ->after($component->getDirectory())
                    : null;

                $arguments['src'] = $source;

                return $arguments;
            })
            ->form(function (TypistEditor $component) {
                return [
                    Components\Grid::make()
                        ->schema([
                            Components\Group::make([
                                $component->getUploader(),
                            ])->columnSpan(1),
                            Components\Group::make([
                                Components\TextInput::make('link_text')
                                    ->label(fn () => trans('typist::typist.media.link_text'))
                                    ->required()
                                    ->visible(fn (Get $get) => $get('type') == 'document'),
                                Components\TextInput::make('alt')
                                    ->label(fn () => trans('typist::typist.media.alt'))
                                    ->hidden(fn (Get $get) => $get('type') == 'document')
                                    ->hintAction(
                                        Action::make('alt_hint_action')
                                            ->label('?')
                                            ->color('primary')
                                            ->tooltip('Learn how to describe the purpose of the image.')
                                            ->url('https://www.w3.org/WAI/tutorials/images/decision-tree', true)
                                    ),
                                Components\TextInput::make('title')
                                    ->label(fn () => trans('typist::typist.media.title')),
                                Components\Group::make([
                                    Components\TextInput::make('width')
                                        ->label(fn () => trans('typist::typist.media.width')),
                                    Components\TextInput::make('height')
                                        ->label(fn () => trans('typist::typist.media.height')),
                                ])->columns()->hidden(fn (Get $get) => $get('type') == 'document'),
                                Components\ToggleButtons::make('alignment')
                                    ->label(fn () => trans('typist::typist.media.alignment.label'))
                                    ->options([
                                        'start' => trans('typist::typist.media.alignment.start'),
                                        'center' => trans('typist::typist.media.alignment.center'),
                                        'end' => trans('typist::typist.media.alignment.end'),
                                    ])
                                    ->grouped()
                                    ->afterStateHydrated(function (Components\ToggleButtons $component, $state) {
                                        if (! $state) {
                                            $component->state('start');
                                        }
                                    }),
                                Components\Checkbox::make('loading')
                                    ->label(fn () => trans('typist::typist.media.loading'))
                                    ->dehydrateStateUsing(function ($state): ?string {
                                        if ($state) {
                                            return 'lazy';
                                        }

                                        return null;
                                    })
                                    ->hidden(fn (Get $get) => $get('type') == 'document'),
                            ])->columnSpan(1),
                        ]),
                    Components\Hidden::make('type')
                        ->default('document'),
                ];
            })
            ->action(function (TypistEditor $component, array $arguments, array $data): void {
                $statePath = $component->getStatePath();

                $source = str_starts_with($data['src'], 'http')
                    ? $data['src']
                    : Storage::disk($component->getDisk())->url($data['src']);

                if ($component->useRelativePaths()) {
                    $source = (string) Str::of($source)
                        ->replace(config('app.url'), '')
                        ->ltrim('/')
                        ->prepend('/');
                }

                $data = Js::from([
                    ...$data,
                    'src' => $source,
                    'coordinates' => [
                        'from' => $arguments['coordinates']['anchor'] ?? 1,
                        'to' => $arguments['coordinates']['head'] ?? $arguments['coordinates']['anchor'] + 1,
                    ],
                ]);

                $component->getLivewire()->js(<<<JS
                    Alpine.nextTick(() => {
                        window.editors['$statePath'].chain().focus().setMedia($data).run()
                    })
                JS);
            })
            ->after(function (TypistEditor $component): void {
                $component->getLivewire()->dispatch('focus-editor', statePath: $component->getStatePath());
            });
    }
}
