<?php

namespace Awcodes\Typist\Concerns;

use Awcodes\Typist\Actions;
use Awcodes\Typist\Support\SuggestionGroup;
use Closure;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

trait HasSuggestions
{
    protected array | Closure | null $suggestions = null;

    protected bool | Closure | null $mergeSuggestionActions = null;

    /**
     * @param  array<SuggestionGroup|Action> | Closure  $actions
     */
    public function suggestions(array | Closure $actions, bool | Closure $merge = true): static
    {
        $this->suggestions = $actions;
        $this->mergeSuggestionActions = $merge;

        return $this;
    }

    /**
     * @return array<SuggestionGroup|Action>
     */
    public function getSuggestions(): array
    {
        if ($this->evaluate($this->mergeSuggestionActions)) {
            return [
                ...$this->getDefaultSuggestions(),
                ...$this->evaluate($this->suggestions),
            ];
        }

        return $this->evaluate($this->suggestions) ?? $this->getDefaultSuggestions();
    }

    public function getSuggestionsForTiptap(): array
    {
        $suggestions = $this->evaluate($this->suggestions) ?? $this->getDefaultSuggestions();

        return collect($this->getSuggestions())
            ->transform(function ($suggestion) {
                return [
                    'name' => $suggestion->getName() ?? 'group',
                    'label' => $suggestion->getLabel(),
                    'icon' => Blade::render("@svg('{$suggestion->getIcon()}', 'w-5 h-5')"),
                    'actionType' => Str::contains($suggestion->getAlpineClickHandler(), 'Livewire') ? 'livewire' : 'alpine',
                    'commandName' => $suggestion->getCommandName(),
                    'commandAttributes' => $suggestion->getCommandAttributes(),
                ];
            })->all();
    }

    public function getDefaultSuggestions(): array
    {
        return [
            Actions\Media::make('suggestMedia'),
            Actions\BulletList::make('suggestBulletList'),
            Actions\OrderedList::make('suggestOrderedList'),
            Actions\Blockquote::make('suggestBlockquote'),
            Actions\HorizontalRule::make('suggestHorizontalRule'),
            Actions\CodeBlock::make('suggestCodeBlock'),
            Actions\Details::make('suggestDetails'),
            Actions\Grid::make('suggestGrid'),
            Actions\Table::make('suggestTable'),
        ];
    }
}
