<?php

namespace Awcodes\Typist\Concerns;

trait CanBeGroupedInToolbar
{
    protected ?string $toolbarGroup = null;

    public function toolbarGroup(string $group): static
    {
        $this->toolbarGroup = $group;

        return $this;
    }

    public function getToolbarGroup(): ?string
    {
        return $this->evaluate($this->toolbarGroup);
    }
}
