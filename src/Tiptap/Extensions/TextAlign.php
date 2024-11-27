<?php

namespace Awcodes\Typist\Tiptap\Extensions;

use Tiptap\Core\Extension;
use Tiptap\Utils\InlineStyle;

class TextAlign extends Extension
{
    public static $name = 'textAlign';

    public function addOptions(): array
    {
        return [
            'types' => [],
            'alignments' => ['start', 'center', 'end', 'justify'],
            'defaultAlignment' => 'start',
        ];
    }

    public function addGlobalAttributes(): array
    {
        return [
            [
                'types' => $this->options['types'],
                'attributes' => [
                    'textAlign' => [
                        'default' => $this->options['defaultAlignment'],
                        'parseHTML' => function ($DOMNode) {
                            return InlineStyle::getAttribute($DOMNode, 'text-align') ?? $this->options['defaultAlignment'];
                        },
                        'renderHTML' => function ($attributes) {
                            if (
                                property_exists($attributes, 'style') && str_contains($attributes->style, 'text-align')
                                || $attributes->textAlign === $this->options['defaultAlignment']
                            ) {
                                return null;
                            }

                            return ['style' => "text-align: {$attributes->textAlign};"];
                        },
                    ],
                ],
            ],
        ];
    }
}
