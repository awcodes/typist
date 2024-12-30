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
            Actions\Media::make('suggestionMedia'),
            Actions\Embed::make('suggestionEmbed'),
            Actions\BulletList::make('suggestionBulletList'),
            Actions\OrderedList::make('suggestionOrderedList'),
            Actions\Blockquote::make('suggestionBlockquote'),
            Actions\HorizontalRule::make('suggestionHorizontalRule'),
            Actions\CodeBlock::make('suggestionCodeBlock'),
            Actions\Details::make('suggestionDetails'),
            Actions\Grid::make('suggestionGrid'),
            Actions\Table::make('suggestionTable'),
        ];
    }
}
