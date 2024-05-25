<?php

namespace Awcodes\Typist\Concerns;

trait CanBeOrdered
{
    protected int | \Closure | null $order = null;

    public function order(int | \Closure $order): static
    {
        $this->order = $order;

        return $this;
    }

    public function getOrder(): ?int
    {
        return $this->evaluate($this->order) ?? 0;
    }
}
