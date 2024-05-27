<?php

namespace Awcodes\Typist\Concerns;

use Awcodes\Typist\Facades\Typist;
use Awcodes\Typist\Support\SuggestionGroup;
use Closure;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Support\Facades\Blade;

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
                $instance = get_class($suggestion);
                $instance = $instance::make($suggestion->getName())->component($this);

                return [
                    'name' => $instance->getName() ?? 'group',
                    'label' => $instance->getLabel(),
                    'icon' => Blade::render("@svg('{$instance->getIcon()}', 'w-5 h-5')"),
                    'actionType' => $instance->getAlpineClickHandler() ? 'alpine' : 'livewire',
                ];
            })->all();
    }

    public function getDefaultSuggestions(): array
    {
        return [
            Typist::getAction('Media'),
            Typist::getAction('BulletList'),
            Typist::getAction('OrderedList'),
            Typist::getAction('Blockquote'),
            Typist::getAction('HorizontalRule'),
            Typist::getAction('CodeBlock'),
            Typist::getAction('Details'),
            Typist::getAction('Grid'),
            Typist::getAction('Alert'),
        ];
    }
}
