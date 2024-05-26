<?php

namespace Awcodes\Typist\Tiptap\Nodes;

use Awcodes\Typist\Facades\Typist;
use Tiptap\Core\Node;

class TypistBlock extends Node
{
    public static $name = 'typistBlock';

    public function addAttributes(): array
    {
        return [
            'identifier' => [
                'default' => null,
            ],
            'values' => [
                'default' => [],
            ],
            'view' => [
                'default' => null,
            ],
        ];
    }

    public function parseHTML(): array
    {
        return [
            [
                'tag' => 'typist-block',
                'getAttrs' => function ($DOMNode) {
                    return json_decode($DOMNode->nodeValue, true);
                },
            ],
        ];
    }

    public function renderHTML($node, $HTMLAttributes = []): array
    {
        $data = $HTMLAttributes;
        $view = null;

        if ($data) {
            foreach (Typist::getActions() as $action) {
                if ($action->getName() === $data['identifier']) {
                    $view = $action->getRenderView((array) $data['values']);
                }
            }
        }

        return [
            'content' => '<div class="typist-block">' . $view . '</div>',
        ];
    }
}
