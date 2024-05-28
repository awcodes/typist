@php
    $statePath = $getStatePath();
    $isDisabled = $isDisabled();
    $mergeTags = $getMergeTags();
@endphp
<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        wire:ignore
        x-ignore
        ax-load
        ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('typist', 'awcodes/typist') }}"
        x-data="typist({
            state: $wire.{{ $applyStateBindingModifiers("entangle('{$statePath}')", isOptimisticallyLive: false) }},
            statePath: @js($statePath),
            placeholder: @js($getPlaceholder()),
            mergeTags: @js($mergeTags),
            suggestions: @js($getSuggestions())
        })"
        id="{{ 'typist-wrapper-' . $statePath }}"
        @class([
            'typist-wrapper',
            'invalid' => $errors->has($statePath),
        ])
        x-on:click.away="isFocused = false"
        x-on:focus-editor.window="focusEditor($event)"
        x-on:dragged-merge-tag.stop="insertMergeTag($event)"
        x-on:handle-suggestion.window="handleSuggestion($event)"
    >
        <template x-if="isLoaded()">
            <div class="typist-toolbar" x-bind:class="{
                'focused': isFocused
            }">
                <x-typist::toolbar-actions class="typist-toolbar-start" :actions="$getToolbar()" />
                <x-typist::toolbar-actions class="typist-toolbar-end" :actions="$getControls()" />
            </div>
        </template>

        <div>
            <div x-ref="bubbleMenu" class="typist-bubble-menu-wrapper">
                <div x-data="{
                    updatedAt: Date.now(),
                    isActive(attrs) {
                        return window.editors['{{ $statePath }}'].isActive(attrs)
                    },
                    getAttrs(name) {
                        return window.editors['{{ $statePath }}'].getAttributes(name)
                    },
                    openModal(action, name) {
                        this.$wire.mountFormComponentAction('{{ $statePath }}', action, this.getAttrs(name))
                    }
                }" x-on:selection-update.window="updatedAt = Date.now()">
                    @foreach($getBubbleMenus() as $bubbleMenu)
                        <x-dynamic-component :component="$bubbleMenu->getView()" :menu="$bubbleMenu" />
                    @endforeach
                </div>
            </div>
        </div>

        <div class="typist-content">
            <div
                x-ref="element"
                {{
                    \Filament\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
                        ->class([
                            'typist-editor prose dark:prose-invert max-w-none',
                        ])
                }}
            ></div>

            @if ((! $isDisabled) && (filled($mergeTags)))
                <x-typist::sidebar :merge-tags="$mergeTags" />
            @endif
        </div>

        <template x-if="isLoaded()">
            <div class="typist-footer">
                <div>
                    <p class="text-xs">Word Count: <span x-text="wordCount"></span>
                </div>
            </div>
        </template>
    </div>
</x-dynamic-component>
