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
            ->active(null)
            ->fillForm(function (array $arguments) {
                return $arguments;
            })
            ->alpineClickHandler("openModal('" . $this->getName() . "', 'link')")
            ->action(function (TypistEditor $component, array $arguments, array $data): void {
                $statePath = $component->getStatePath();

                $data = Js::from($data);

                $coords = Js::from([
                    'from' => $arguments['coordinates']['anchor'] ?? 1,
                    'to' => $arguments['coordinates']['head'] ?? 1,
                ]);

                $component->getLivewire()->js(<<<JS
                    Alpine.nextTick(() => {
                        window.editors['$statePath'].chain().focus().setTextSelection($coords).extendMarkRange('link').setLink($data).run()
                    })
                JS);
            });
    }
}
