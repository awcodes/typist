@props([
    'mergeTags' => null,
    'blocks' => null,
])
<div
    class="typist-sidebar"
    x-show="sidebarOpen"
    x-bind:class="{
        'focused': isFocused
    }"
>
    @if ($mergeTags)
        @foreach ($mergeTags as $mergeTag)
            <div
                draggable="true"
                x-on:dragstart="$event?.dataTransfer?.setData('mergeTag', @js($mergeTag))"
                class="typist-sidebar-item"
            >
                &lcub;&lcub; {{ $mergeTag }} &rcub;&rcub;
            </div>
        @endforeach
    @endif

{{--            @foreach ($blocks as $block)--}}
{{--                <div--}}
{{--                    draggable="true"--}}
{{--                    x-on:dragstart="$event?.dataTransfer?.setData('block', @js($block->getIdentifier()))"--}}
{{--                    class="cursor-move grid-col-1 flex items-center gap-2 rounded border text-xs px-3 py-2 bg-white dark:bg-gray-800 dark:border-gray-700"--}}
{{--                >--}}
{{--                    @if ($block->getIcon())--}}
{{--                        <x-filament::icon--}}
{{--                            :icon="$block->getIcon()"--}}
{{--                            class="h-5 w-5"--}}
{{--                        />--}}
{{--                    @endif--}}

{{--                    {{ $block->getLabel() }}--}}
{{--                </div>--}}
{{--            @endforeach--}}
</div>
