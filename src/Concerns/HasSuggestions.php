<?php

namespace Awcodes\Typist\Concerns;

use Awcodes\Typist\Support\SuggestionGroup;
use Closure;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

trait HasSuggestions
{
    protected array | Closure | null $suggestions = null;

    /**
     * @param  array<SuggestionGroup|Action> | Closure  $actions
     */
    public function suggestions(array | Closure $actions): static
    {
        $this->suggestions = $actions;

        return $this;
    }

    /**
     * @return array<SuggestionGroup|Action>
     */
    public function getSuggestions(): array
    {
        $suggestions = $this->evaluate($this->suggestions) ?? $this->getDefaultSuggestions();

        return collect($suggestions)
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
            $this->getAction('Media'),
            $this->getAction('BulletList'),
            $this->getAction('OrderedList'),
            $this->getAction('Blockquote'),
            $this->getAction('HorizontalRule'),
            $this->getAction('CodeBlock'),
            $this->getAction('Details'),
            $this->getAction('Grid'),
            $this->getAction('Alert'),
        ];
    }
}
