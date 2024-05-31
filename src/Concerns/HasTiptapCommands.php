<?php

namespace Awcodes\Typist\Concerns;

trait HasTiptapCommands
{
    protected ?string $commandName = null;

    protected string | array | bool | null $commandAttributes = null;

    public function command(?string $name, string | array | bool | null $attributes = null): static
    {
        $this->commandName = $name;
        $this->commandAttributes = $attributes;

        return $this;
    }

    public function getCommandName(): ?string
    {
        return $this->evaluate($this->commandName) ?? null;
    }

    public function getCommandAttributes(): string | array | bool | null
    {
        return $this->evaluate($this->commandAttributes) ?? null;
    }

    public function hasTiptapCommands(): bool
    {
        return $this->evaluate($this->commandName) || $this->evaluate($this->commandAttributes);
    }
}
