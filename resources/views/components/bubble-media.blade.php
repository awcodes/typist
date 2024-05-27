@props([
    'menu' => null
])

<div class="typist-bubble-menu" x-show="isActive('media', updatedAt)" x-cloak>
    @foreach($menu->getActions() as $action)
        {{ $action }}
    @endforeach
{{--    {{ $getAction('MediaAction')->active(null)->alpineClickHandler("openModal('MediaAction', 'media')") }}--}}
{{--    {{ $getAction('RemoveMediaAction')->active(null) }}--}}
</div>
