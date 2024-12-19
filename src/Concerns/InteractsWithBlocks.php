<?php

namespace Awcodes\Typist\Concerns;

use Awcodes\Typist\TypistEditor;
use Closure;

trait InteractsWithBlocks
{
    protected array | Closure $blocks = [];

    public function blocks(array | Closure $blocks): static
    {
        $this->blocks = $blocks;

        return $this;
    }

    public function getBlocks(): array
    {
        return $this->evaluate($this->blocks) ?? [];
    }

    public function renderBlockViews(array $document, TypistEditor $component): array
    {
        $content = $document['content'];

        foreach ($content as $k => $block) {
            if ($block['type'] === 'typistBlock') {
                $instance = $this->getAction($block['attrs']['identifier']);
                $content[$k]['attrs']['view'] = $instance?->getEditorView($block['attrs']['values']);
            } elseif (array_key_exists('content', $block)) {
                $content[$k] = $this->renderBlockViews($block, $component);
            }
        }

        $document['content'] = $content;

        return $document;
    }

    public function sanitizeBlocksBeforeSave(array $document): array
    {
        $content = $document['content'];

        foreach ($content as $k => $block) {
            if ($block['type'] === 'typistBlock') {
                unset($content[$k]['attrs']['view']);
            } elseif (array_key_exists('content', $block)) {
                $content[$k] = $this->sanitizeBlocksBeforeSave($block);
            }
        }

        $document['content'] = $content;

        return $document;
    }
}
