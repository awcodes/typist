<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\Tiptap\Nodes\Embed as EmbedExtension;
use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Get;
use Illuminate\Support\Js;

class Embed extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(fn () => trans('typist::typist.embed.label'))
            ->icon('typist-embed')
            ->iconButton()
            ->active('embed')
            ->converterExtensions(new EmbedExtension)
            ->fillForm([
                'responsive' => true,
                'width' => 16,
                'height' => 9,
            ])
            ->form([
                TextInput::make('src')
                    ->label(fn () => trans('typist::typist.embed.url'))
                    ->live()
                    ->required(),
                CheckboxList::make('options')
                    ->hiddenLabel()
                    ->gridDirection('row')
                    ->columns(3)
                    ->visible(function (Get $get) {
                        return $get('src');
                    })
                    ->options(function (Get $get) {
                        if (str_contains($get('src'), 'youtu')) {
                            return [
                                'controls' => trans('typist::typist.embed.controls'),
                                'nocookie' => trans('typist::typist.embed.nocookie'),
                            ];
                        }

                        return [
                            'autoplay' => trans('typist::typist.embed.autoplay'),
                            'loop' => trans('typist::typist.embed.loop'),
                            'title' => trans('typist::typist.embed.title'),
                            'byline' => trans('typist::typist.embed.byline'),
                            'portrait' => trans('typist::typist.embed.portrait'),
                        ];
                    })
                    ->dehydrateStateUsing(function (Get $get, $state) {
                        if (str_contains($get('src'), 'youtu')) {
                            return [
                                'controls' => in_array('controls', $state) ? 1 : 0,
                                'nocookie' => in_array('nocookie', $state) ? 1 : 0,
                            ];
                        } else {
                            return [
                                'autoplay' => in_array('autoplay', $state) ? 1 : 0,
                                'loop' => in_array('loop', $state) ? 1 : 0,
                                'title' => in_array('title', $state) ? 1 : 0,
                                'byline' => in_array('byline', $state) ? 1 : 0,
                                'portrait' => in_array('portrait', $state) ? 1 : 0,
                            ];
                        }
                    }),
                TimePicker::make('start_at')
                    ->label(fn () => trans('typist::typist.embed.start_at'))
                    ->live()
                    ->date(false)
                    ->visible(function (Get $get) {
                        return str_contains($get('src'), 'youtu');
                    })
                    ->afterStateHydrated(function (TimePicker $component, $state): void {
                        if (! $state) {
                            return;
                        }

                        $state = CarbonInterval::seconds($state)->cascade();
                        $component->state(Carbon::parse($state->h . ':' . $state->i . ':' . $state->s)->format('Y-m-d H:i:s'));
                    })
                    ->dehydrateStateUsing(function ($state): int {
                        if (! $state) {
                            return 0;
                        }

                        return Carbon::parse($state)->diffInSeconds('00:00:00');
                    }),
                Checkbox::make('responsive')
                    ->default(true)
                    ->live()
                    ->label(fn () => trans('typist::typist.embed.responsive'))
                    ->afterStateUpdated(function (callable $set, $state) {
                        if ($state) {
                            $set('width', '16');
                            $set('height', '9');
                        } else {
                            $set('width', '640');
                            $set('height', '480');
                        }
                    })
                    ->columnSpan('full'),
                Group::make([
                    TextInput::make('width')
                        ->live()
                        ->required()
                        ->label(fn () => trans('typist::typist.embed.width'))
                        ->default('16'),
                    TextInput::make('height')
                        ->live()
                        ->required()
                        ->label(fn () => trans('typist::typist.embed.height'))
                        ->default('9'),
                ])->columns(['md' => 2]),
            ])
            ->action(function (TypistEditor $component, array $arguments, array $data): void {
                $statePath = $component->getStatePath();

                $data = Js::from([
                    ...$data,
                    'coordinates' => [
                        'from' => $arguments['coordinates']['anchor'] ?? 1,
                        'to' => $arguments['coordinates']['head'] ?? $arguments['coordinates']['anchor'] + 1,
                    ],
                ]);

                $component->getLivewire()->js(<<<JS
                    Alpine.nextTick(() => {
                        window.editors['$statePath'].chain().focus().setEmbed($data).run()
                    })
                JS);
            })
            ->after(function (TypistEditor $component): void {
                $component->getLivewire()->dispatch('focus-editor', statePath: $component->getStatePath());
            });
    }
}
