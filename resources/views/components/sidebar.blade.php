@props([
    'mergeTags' => null,
    'actions' => null,
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

    @if ($actions)
        @foreach ($actions as $action)
            <div
                draggable="true"
                x-on:dragstart="$event?.dataTransfer?.setData('block', @js($action->getName()))"
                class="cursor-move grid-col-1 flex items-center gap-2 rounded border text-xs ps-3 pe-4 py-2 bg-white dark:bg-gray-800 dark:border-gray-700"
            >
                @if ($action->getIcon())
                    <x-filament::icon
                        :icon="$action->getIcon()"
                        class="h-5 w-5"
                    />
                @endif

                {{ $action->getLabel() }}
            </div>
        @endforeach
    @endif
</div>
