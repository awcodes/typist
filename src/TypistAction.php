<?php

namespace Awcodes\Typist;

use Filament\Forms\Components\Actions\Action;
use Filament\Support\Concerns\HasExtraAlpineAttributes;
use Illuminate\Support\Js;

class TypistAction extends Action
{
    use Concerns\CanBeGroupedInToolbar;
    use Concerns\CanBeOrdered;
    use HasExtraAlpineAttributes;

    public const ICON_BUTTON_VIEW = 'typist::components.icon-button-action';

    protected ?string $active = null;

    protected ?string $renderView = null;

    protected ?string $editorView = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
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

    public function getActive(): ?string
    {
        return $this->active ?? null;
    }

    public function renderView(string $view): static
    {
        $this->renderView = $view;

        return $this;
    }

    public function getRenderView(array $data = []): ?string
    {
        return $this->evaluate($this->renderView)
            ? view($this->renderView, $data)
            : null;
    }

    public function editorView(string $view): static
    {
        $this->editorView = $view;

        return $this;
    }

    public function getEditorView(array $data = []): ?string
    {
        return $this->evaluate($this->editorView)
            ? view($this->editorView, $data)
            : null;
    }
}
