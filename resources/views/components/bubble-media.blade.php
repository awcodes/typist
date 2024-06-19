@props([
    'menu' => null,
    'field' => null,
])

<div class="typist-bubble-menu" x-show="isActive('media', updatedAt)" x-cloak>
    @foreach($menu->getActions() as $action)
        @php
            $action = $field->getAction($action->getName());
        @endphp
        @if($action->isVisible())
            {{ $action }}
        @endif
    @endforeach
</div>
