<?php

namespace Awcodes\Typist;

use Filament\Forms\Components\Actions\Action;
use Filament\Support\Concerns\HasExtraAlpineAttributes;
use Illuminate\Support\Js;

class TypistAction extends Action
{
    use Concerns\HasTiptapCommands;
    use HasExtraAlpineAttributes;

    protected ?string $active = null;

    protected ?string $renderView = null;

    protected ?string $editorView = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
    }

    public function active(?string $name = null, string | array $attributes = []): static
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

    public function getExtraAttributes(): array
    {
        return array_merge(
            parent::getExtraAttributes(),
            $this->getActive() ? ['x-bind:class' => '{ \'is-active\': isActive(' . $this->getActive() . ', updatedAt)}'] : [],
        );
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

    public function getLivewireClickHandler(): ?string
    {
        return null;
    }

    public function getAlpineClickHandler(): ?string
    {
        if ($this->evaluate($this->alpineClickHandler)) {
            return parent::getAlpineClickHandler();
        }

        if ($this->hasTiptapCommands()) {
            $attributes = $this->getCommandAttributes();

            if ($attributes && is_array($attributes)) {
                $attributes = Js::from($attributes);
            } else {
                $attributes = '"' . $attributes . '"';
            }

            $handler = 'handleCommand("' . $this->getCommandName() . '", ' . $attributes . ')';

            if ($this->shouldClose()) {
                $handler .= '; close();';
            }

            return $handler;
        }

        return 'handleLivewire("' . $this->getName() . '")';
    }
}
