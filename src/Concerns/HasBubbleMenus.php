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
            BubbleMenu::make([
                Typist::getAction('Link')
                    ->alpineClickHandler("openModal('Link', 'link')"),
                Typist::getAction('Unlink'),
            ])->view('typist::bubble-link'),
            BubbleMenu::make([
                Typist::getAction('Media')
                    ->alpineClickHandler("openModal('Media', 'media')"),
                Typist::getAction('RemoveMedia'),
            ])->view('typist::bubble-media'),
        ];
    }
}
