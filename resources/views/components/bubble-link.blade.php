@props([
    'menu' => null,
    'editor' => null,
])

<div class="typist-bubble-menu" x-show="isActive('link', updatedAt)" x-cloak>
    <span x-text="getAttrs('link', updatedAt).href" class="max-w-xs truncate overflow-hidden whitespace-nowrap"></span>
{{--    @foreach($menu->getActions() as $action)--}}
{{--        {{ $action }}--}}
{{--    @endforeach--}}
    {{ $editor->getAction('EditLink')->active(null)->alpineClickHandler("openModal('EditLink', 'link')") }}
    {{ $editor->getAction('Unlink')->active(null) }}
</div>
