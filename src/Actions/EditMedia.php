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

class EditMedia extends Media
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->fillForm(function (TypistEditor $component, array $arguments) {
                $source = isset($arguments['src']) && $arguments['src'] !== ''
                    ? $component->getDirectory() . Str::of($arguments['src'])
                        ->after($component->getDirectory())
                    : null;

                $arguments['src'] = $source;

                return $arguments;
            })
            ->active(null);
    }
}
