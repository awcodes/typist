@props([
    'menu' => null,
    'editor' => null,
])

<div class="typist-bubble-menu" x-show="isActive('media', updatedAt)" x-cloak>
{{--    @foreach($menu->getActions() as $action)--}}
{{--        {{ $action }}--}}
{{--    @endforeach--}}
    {{ $editor->getAction('EditMedia')->active(null)->alpineClickHandler("openModal('EditMedia', 'media')") }}
    {{ $editor->getAction('RemoveMedia')->active(null) }}
</div>
