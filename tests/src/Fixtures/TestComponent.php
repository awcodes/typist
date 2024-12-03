<?php

namespace Awcodes\Typist\Tests\Fixtures;

use Awcodes\Typist\TypistEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class TestComponent extends TestForm
{
    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                TextInput::make('title'),
                TextInput::make('slug'),
                TypistEditor::make('content'),
            ]);
    }
}
