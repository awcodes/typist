<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;
use Filament\Forms\Components;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Js;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Media extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('typist-media')
            ->iconButton()
            ->fillForm(function (TypistEditor $component, array $arguments) {
                $source = $arguments['src'] !== ''
                    ? $component->getDirectory() . Str::of($arguments['src'])
                        ->after($component->getDirectory())
                    : null;

                $arguments['src'] = $source;

                return $arguments;
            })
            ->form([
                Components\Grid::make()
                    ->schema([
                        Components\Group::make([
                            Components\FileUpload::make('src')
                                ->label('File')
                                ->disk($this->getDisk())
                                ->directory($this->getDirectory())
                                ->visibility($this->getVisibility())
                                ->preserveFilenames($this->shouldPreserveFileNames())
                                ->acceptedFileTypes($this->getAcceptedFileTypes())
                                ->maxFiles(1)
                                ->maxSize($this->getMaxFileSize())
                                ->imageResizeMode($this->getImageResizeMode())
                                ->imageCropAspectRatio($this->getImageCropAspectRatio())
                                ->imageResizeTargetWidth($this->getImageResizeTargetWidth())
                                ->imageResizeTargetHeight($this->getImageResizeTargetHeight())
                                ->required()
                                ->live()
                                ->afterStateUpdated(function (TemporaryUploadedFile $state, Set $set): void {
                                    if (Str::contains($state->getMimeType(), 'image')) {
                                        $set('type', 'image');
                                        if (! Str::contains($state->getMimeType(), 'svg')) {
                                            $set('width', $state->dimensions()[0]);
                                            $set('height', $state->dimensions()[1]);
                                        } else {
                                            $set('width', 50);
                                            $set('height', 50);
                                        }
                                    } else {
                                        $set('type', 'document');
                                    }
                                })
                                ->saveUploadedFileUsing(function (BaseFileUpload $component, TemporaryUploadedFile $file): string {
                                    $filename = $component->shouldPreserveFilenames()
                                        ? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
                                        : Str::uuid();
                                    $storeMethod = $component->getVisibility() === 'public' ? 'storePubliclyAs' : 'storeAs';
                                    $extension = $file->getClientOriginalExtension();
                                    $storage = Storage::disk($component->getDiskName());

                                    if ($storage->exists(ltrim($component->getDirectory() . '/' . $filename . '.' . $extension, '/'))) {
                                        $filename = $filename . '-' . time();
                                    }

                                    $upload = $file->{$storeMethod}($component->getDirectory(), $filename . '.' . $extension, $component->getDiskName());

                                    return $storage->url($upload);
                                }),
                        ])->columnSpan(1),
                        Components\Group::make([
                            Components\TextInput::make('link_text')
                                ->label('Link Text')
                                ->required()
                                ->visible(fn (Get $get) => $get('type') == 'document'),
                            Components\TextInput::make('alt')
                                ->label('Alt Text')
                                ->hidden(fn (Get $get) => $get('type') == 'document')
                                ->hintAction(
                                    Action::make('alt_hint_action')
                                        ->label('?')
                                        ->color('primary')
                                        ->tooltip('Learn how to describe the purpose of the image.')
                                        ->url('https://www.w3.org/WAI/tutorials/images/decision-tree', true)
                                ),
                            Components\TextInput::make('title')
                                ->label('Title'),
                            Components\Group::make([
                                Components\TextInput::make('width')
                                    ->label('Width'),
                                Components\TextInput::make('height')
                                    ->label('Height'),
                            ])->columns()->hidden(fn (Get $get) => $get('type') == 'document'),
                            Components\ToggleButtons::make('alignment')
                                ->label('Alignment')
                                ->options([
                                    'start' => 'Start',
                                    'center' => 'Center',
                                    'end' => 'End',
                                ])
                                ->grouped()
                                ->default('start'),
                            Components\Checkbox::make('loading')
                                ->label('Lazy Load')
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
            ])
            ->action(function (TypistEditor $component, array $arguments, array $data): void {
                $statePath = $component->getStatePath();

                $source = str_starts_with($data['src'], 'http')
                    ? $data['src']
                    : Storage::disk($this->getDisk())->url($data['src']);

                if ($component->useRelativePaths()) {
                    $source = (string) Str::of($source)
                        ->replace(config('app.url'), '')
                        ->ltrim('/')
                        ->prepend('/');
                }

                $data = Js::from([
                    ...$data,
                    'src' => $source,
                ]);

                $component->getLivewire()->js(<<<JS
                    window.editors['$statePath'].chain().focus().setMedia($data).run()
                JS);
            })
            ->after(function (TypistEditor $component): void {
                $component->getLivewire()->dispatch('focus-editor', statePath: $component->getStatePath());
            })
            ->active('media');
    }

    public function getAcceptedFileTypes(): array
    {
        return config('typist.media.accepted_file_types');
    }

    public function getDirectory(): string
    {
        return config('typist.media.directory');
    }

    public function getDisk(): string
    {
        return config('typist.media.disk');
    }

    public function getMaxFileSize(): int
    {
        return config('typist.media.max_file_size');
    }

    public function getVisibility(): string
    {
        return config('typist.media.visibility');
    }

    public function shouldPreserveFileNames(): bool
    {
        return config('typist.media.preserve_file_names');
    }

    public function getImageResizeMode(): ?string
    {
        return config('typist.media.image_resize_mode');
    }

    public function getImageCropAspectRatio(): ?string
    {
        return config('typist.media.image_crop_aspect_ratio');
    }

    public function getImageResizeTargetWidth(): ?int
    {
        return config('typist.media.image_resize_target_width');
    }

    public function getImageResizeTargetHeight(): ?int
    {
        return config('typist.media.image_resize_target_height');
    }

    public function getUseRelativePaths(): bool
    {
        return config('typist.media.use_relative_paths');
    }
}
