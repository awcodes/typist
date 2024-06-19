@props([
    'menu' => null,
    'field' => null,
])

<div class="typist-bubble-menu" x-show="editor().isActive('link', updatedAt)" x-cloak>
    <span x-text="editor().getAttributes('link', updatedAt).href" class="max-w-xs truncate overflow-hidden whitespace-nowrap"></span>
    @foreach($menu->getActions() as $action)
        @php
            $action = $field->getAction($action->getName());
        @endphp
        @if($action->isVisible())
            {{ $action }}
        @endif
    @endforeach
</div>
