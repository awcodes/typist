<?php

namespace Awcodes\Typist\Concerns;

use Awcodes\Typist\Actions;
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

    public function getBubbleMenuActions(): array | Closure | null
    {
        $flatActions = [];

        collect($this->getBubbleMenus())
            ->each(function ($action) use (&$flatActions) {
                foreach ($action->getActions() as $action) {
                    $flatActions[] = $action;
                }
            });

        return $flatActions;
    }

    /**
     * @return array<BubbleMenu>
     */
    public function getBubbleMenus(): array
    {
        return $this->evaluate($this->bubbleMenus) ?? $this->getDefaultBubbleMenus();
    }

    public function getDefaultBubbleMenus(): array
    {
        return [
            BubbleMenu::make([
                Actions\EditLink::make('bubbleEditLink'),
                Actions\Unlink::make('bubbleUnlink'),
            ])->view('typist::bubble-link'),
            BubbleMenu::make([
                Actions\EditMedia::make('bubbleEditMedia'),
                Actions\RemoveMedia::make('bubbleRemoveMedia'),
            ])->view('typist::bubble-media'),
        ];
    }
}
