<?php

namespace Awcodes\Typist\Actions;

use Awcodes\Typist\TypistEditor;
use Illuminate\Support\Str;

class EditMedia extends Media
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(trans('typist::typist.edit_media'))
            ->alpineClickHandler("openModal('" . $this->getName() . "', 'media')")
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
