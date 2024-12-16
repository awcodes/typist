<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    @if ($getCustomStyles())
        <div
            wire:ignore
            x-data="{}"
            x-load-css="[{{ \Illuminate\Support\Js::from($getCustomStyles()) }}]"
        ></div>
    @endif
    <div
        {{
            \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                ->class([
                    'typist-entry',
                ])
        }}
    >
        <div class="tiptap">
            {!! typist($getState())->mergeTagsMap($getMergeTagsMap())->toHtml() !!}
        </div>
    </div>
</x-dynamic-component>
