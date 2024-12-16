<?php

namespace Awcodes\Typist;

use Awcodes\Typist\Concerns\HasCustomStyles;
use Closure;
use Filament\Infolists\Components\Entry;

class TypistEntry extends Entry
{
    use HasCustomStyles;

    protected array | Closure | null $mergeTagsMap = null;

    protected string $view = 'typist::typist-entry';

    public function mergeTagsMap(array | Closure $map): static
    {
        $this->mergeTagsMap = $map;

        return $this;
    }

    public function getMergeTagsMap(): array
    {
        return $this->evaluate($this->mergeTagsMap) ?? [];
    }
}
