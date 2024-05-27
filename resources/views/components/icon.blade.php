@php
    use Filament\Support\Enums\ActionSize;
    use Filament\Support\Enums\IconSize;
@endphp

@props([
    'form' => null,
    'formId' => null,
    'icon' => null,
    'iconAlias' => null,
    'iconSize' => null,
    'loadingIndicator' => true,
    'size' => ActionSize::Medium,
])

@php
    if (! $size instanceof ActionSize) {
        $size = filled($size) ? (ActionSize::tryFrom($size) ?? $size) : null;
    }

    $iconSize ??= match ($size) {
        ActionSize::ExtraSmall => IconSize::Small,
        ActionSize::Small, ActionSize::Medium => IconSize::Medium,
        ActionSize::Large, ActionSize::ExtraLarge => IconSize::Large,
        default => IconSize::Medium,
    };

    if (! $iconSize instanceof IconSize) {
        $iconSize = filled($iconSize) ? (IconSize::tryFrom($iconSize) ?? $iconSize) : null;
    }

    $iconClasses = \Illuminate\Support\Arr::toCssClasses([
        'fi-icon-btn-icon',
        match ($iconSize) {
            IconSize::Small => 'h-4 w-4',
            IconSize::Medium => 'h-5 w-5',
            IconSize::Large => 'h-6 w-6',
            default => $iconSize,
        },
    ]);

    $wireTarget = $loadingIndicator ? $attributes->whereStartsWith(['wire:target', 'wire:click'])->filter(fn ($value): bool => filled($value))->first() : null;

    $hasLoadingIndicator = filled($wireTarget) || ($type === 'submit' && filled($form));

    if ($hasLoadingIndicator) {
        $loadingIndicatorTarget = html_entity_decode($wireTarget ?: $form, ENT_QUOTES);
    }
@endphp

<x-filament::icon
    :attributes="
        \Filament\Support\prepare_inherited_attributes(
            new \Illuminate\View\ComponentAttributeBag([
                'alias' => $iconAlias,
                'icon' => $icon,
                'wire:loading.remove.delay.' . config('filament.livewire_loading_delay', 'default') => $hasLoadingIndicator,
                'wire:target' => $hasLoadingIndicator ? $loadingIndicatorTarget : null,
            ])
        )->class([$iconClasses])
    "
/>
