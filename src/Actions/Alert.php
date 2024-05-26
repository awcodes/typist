<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistAction;
use Awcodes\Typist\TypistEditor;
use Filament\Forms\Components;
use Illuminate\Support\Js;

class Alert extends TypistAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('heroicon-o-exclamation-triangle')
            ->iconButton()
            ->fillForm(function (array $arguments) {
                return $arguments;
            })
            ->form([
                Components\Radio::make('color')
                    ->inline()
                    ->inlineLabel(false)
                    ->options([
                        'info' => 'Info',
                        'success' => 'Success',
                        'warning' => 'Warning',
                        'danger' => 'Danger',
                    ]),
                Components\Checkbox::make('dismissible'),
                Components\Textarea::make('message'),
            ])
            ->action(function (TypistEditor $component, array $arguments, array $data, $action): void {
                $statePath = $component->getStatePath();

                $data = Js::from([
                    'identifier' => $this->getName(),
                    'values' => $data,
                    'view' => $action->getEditorView($data),
                ]);

                $component->getLivewire()->js(<<<JS
                    window.editors['$statePath'].chain().focus().insertBlock($data).run()
                JS);
            })
            ->after(function (TypistEditor $component): void {
                $component->getLivewire()->dispatch('focus-editor', statePath: $component->getStatePath());
            })
            ->active('typistBlock', ['identifier' => $this->getName()])
            ->editorView('typist::components.alert')
            ->renderView('typist::components.alert');
    }
}
