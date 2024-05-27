@props([
    'menu' => null
])

<div class="typist-bubble-menu" x-show="isActive('link', updatedAt)" x-cloak>
    <span x-text="getAttrs('link', updatedAt).href" class="max-w-xs truncate overflow-hidden whitespace-nowrap"></span>
    @foreach($menu->getActions() as $action)
        {{ $action }}
    @endforeach
{{--    {{ $getAction('LinkAction')->active(null)->alpineClickHandler("openModal('LinkAction', 'link')") }}--}}
{{--    {{ $getAction('UnlinkAction')->active(null) }}--}}
</div>
