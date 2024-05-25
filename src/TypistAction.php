<?php

namespace Awcodes\Typist;

use Filament\Forms\Components\Actions\Action;
use Filament\Support\Concerns\HasExtraAlpineAttributes;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Js;
use Illuminate\Support\Str;

class TypistAction extends Action
{
    use Concerns\CanBeGroupedInToolbar;
    use Concerns\CanBeOrdered;
    use HasExtraAlpineAttributes;

    public const ICON_BUTTON_VIEW = 'typist::components.icon-button-action';

    protected ?string $active = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
    }

    public function getName(): ?string
    {
        return (string) Str::of($this->evaluate($this->name))->before('Action')->append('Action');
    }

    public function getLabel(): string | Htmlable | null
    {
        return (string) Str::of(parent::getLabel())->before('action');
    }

    public function active(?string $name = null, array $attributes = []): static
    {
        $string = '';

        if ($name && filled($attributes)) {
            $string = "'{$name}', " . Js::from($attributes);
        } elseif (! $name && filled($attributes)) {
            $string = Js::from($attributes);
        } elseif ($name && empty($attributes)) {
            $string = "'{$name}'";
        } else {
            $string = null;
        }

        $this->active = $string;

        return $this;
    }

    public function isVisibleWhen(?string $name = null, array | string $attributes = []): static
    {
        $this->visibleWhenName = $name;
        $this->visibleWhenAttributes = $attributes;

        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function visibleWhen(): ?array
    {
        return [
            'name' => $this->visibleWhenName,
            'attributes' => $this->visibleWhenAttributes,
        ];
    }
}
