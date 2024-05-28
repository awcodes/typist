<?php

namespace Awcodes\Typist\Concerns;

use Closure;

trait HasMergeTags
{
    protected array | Closure $mergeTags = [];

    public function mergeTags(array | Closure $mergeTags): static
    {
        $this->mergeTags = $mergeTags;

        return $this;
    }

    public function getMergeTags(): array
    {
        return $this->evaluate($this->mergeTags) ?? [];
    }
}
