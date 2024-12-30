@php
    $statePath = $getStatePath();
    $isDisabled = $isDisabled();
    $mergeTags = $getMergeTags();
    $sidebarActions = $getSidebarActions();
    $customStyles = $getCustomStyles();
@endphp
<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    @if ($customStyles)
        <div
            wire:ignore
            x-data="{}"
            x-load-css="[@js($customStyles)]"
        ></div>
    @endif
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
            suggestions: @js($getSuggestionsForTiptap()),
            mentions: @js($getMentions()),
            allowedExtensions: @js($getAllowedExtensions()),
            headingLevels: @js($getHeadingLevels()),
            customDocument: @js($getCustomDocument())
        })"
        id="{{ 'typist-wrapper-' . $statePath }}"
        @class([
            'typist-wrapper',
            'invalid' => $errors->has($statePath),
        ])
        x-bind:class="{
            'fullscreen': fullscreen,
            'display-mobile': viewport === 'mobile',
            'display-tablet': viewport === 'tablet',
            'display-desktop': viewport === 'desktop',
        }"
        x-on:click.away="blurEditor()"
        x-on:focus-editor.window="focusEditor($event)"
        x-on:dragged-merge-tag.stop="insertMergeTag($event)"
        x-on:dragged-block.stop="insertBlock($event)"
        x-on:handle-suggestion.window="handleSuggestion($event)"
    >
        <div class="typist-toolbar" x-bind:class="{
            'focused': isFocused
        }">
            <x-typist::toolbar-actions class="typist-toolbar-start" :actions="$getToolbar()" :field="$field" />
            <x-typist::toolbar-actions class="typist-toolbar-end" :actions="$getControls()" :field="$field" />
        </div>

        <div class="typist-content">
            <div class="typist-editor-wrapper">
                <div class="typist-bubble-menu-wrapper">
                    <div
                        x-data="{
                            updatedAt: Date.now(),
                            openModal(action, name) {
                                this.$wire.mountFormComponentAction('{{ $statePath }}', action, {
                                    coordinates: editor().view.state.selection,
                                    ...editor().getAttributes(name),
                                })
                            }
                        }"
                        x-on:selection-update.window="updatedAt = Date.now()"
                    >
                        @foreach($getBubbleMenus() as $bubbleMenu)
                            <x-dynamic-component :component="$bubbleMenu->getView()" :menu="$bubbleMenu" :field="$field" />
                        @endforeach
                    </div>
                </div>
                <div
                    x-ref="element"
                    {{
                        \Filament\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
                            ->class([
                                'typist-editor prose dark:prose-invert max-w-none',
                            ])
                    }}
                ></div>
            </div>

            @if (
                (! $isSidebarHidden()) &&
                (! $isDisabled) && (filled($mergeTags) || filled($sidebarActions))
            )
                <x-typist::sidebar :merge-tags="$mergeTags" :actions="$sidebarActions" />
            @endif
        </div>

        @if($shouldShowWordCount())
        <div class="typist-footer">
            <div>
                <p class="text-xs">Word Count: <span x-text="wordCount"></span>
            </div>
        </div>
        @endif
    </div>
</x-dynamic-component>
