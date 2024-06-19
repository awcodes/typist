<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistEditor;
use Illuminate\Support\Js;

class EditLink extends Link
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.edit_link'))
            ->fillForm(function (array $arguments) {
                return $arguments;
            })
            ->alpineClickHandler("openModal('" . $this->getName() . "', 'link')")
            ->action(function (TypistEditor $component, array $arguments, array $data): void {
                $statePath = $component->getStatePath();
                $data = Js::from($data);
                $component->getLivewire()->js(<<<JS
                    window.editors['$statePath'].chain().focus().extendMarkRange('link').setLink($data).run()
                JS);
            })
            ->active(null);
    }
}
