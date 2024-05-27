@props([
    'actions' => null,
])

<div {{ $attributes }}>
@foreach ($actions as $action)
    @if ($action instanceof \Filament\Actions\ActionGroup)
        <x-filament-actions::group
            :actions="$action->getActions()"
            :icon="$action->getIcon()"
            :button="$action->isButton()"
            :label="$action->getLabel()"
            :color="$action->getColor()"
            :size="$action->getSize()"
            :group="$action->getGroup()"
            :icon-position="$action->getIconPosition()"
        ></x-filament-actions::group>
    @else
        @if($action->isVisible())
            {{ $action }}
        @endif
    @endif
@endforeach
</div>
