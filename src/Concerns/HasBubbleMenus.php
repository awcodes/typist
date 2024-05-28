<?php

namespace Awcodes\Typist\Concerns;

use Awcodes\Typist\Facades\Typist;
use Awcodes\Typist\Support\BubbleMenu;
use Closure;

trait HasBubbleMenus
{
    protected array | Closure | null $bubbleMenus = null;

    /**
     * @param  array<BubbleMenu> | Closure  $menus
     */
    public function bubbleMenus(array | Closure $menus): static
    {
        $this->bubbleMenus = $menus;

        return $this;
    }

    /**
     * @return array<BubbleMenu>
     */
    public function getBubbleMenus(): array
    {
        return $this->evaluate($this->bubbleMenus) ?? [
            BubbleMenu::make([])->view('typist::bubble-link'),
            BubbleMenu::make([])->view('typist::bubble-media'),
        ];
    }
}
