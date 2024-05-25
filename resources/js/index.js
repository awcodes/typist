import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import StatePathExtension from './extensions/StatePathExtension.js'
import LinkExtension from './extensions/LinkExtension.js'
import ClassExtension from './extensions/ClassExtension.js'
import IdExtension from './extensions/IdExtension.js'
import MergeTag from './extensions/MergeTag.js'
import DragAndDropExtension from './extensions/DragAndDropExtension.js'
import { Underline } from '@tiptap/extension-underline'
import { Subscript } from '@tiptap/extension-subscript'
import { Superscript } from '@tiptap/extension-superscript'
import TextAlignExtension from './extensions/TextAlignExtension.js'
import { Table } from '@tiptap/extension-table'
import { TableRow } from '@tiptap/extension-table-row'
import { TableHeader } from '@tiptap/extension-table-header'
import { TableCell } from '@tiptap/extension-table-cell'
import { TextStyle } from '@tiptap/extension-text-style'
import Grid from './extensions/Grid/Grid.js'
import GridColumn from './extensions/Grid/GridColumn.js'
import Details from './extensions/Details/Details.js'
import DetailsContent from './extensions/Details/DetailsContent.js'
import DetailsSummary from './extensions/Details/DetailsSummary.js'
import MediaExtension from './extensions/MediaExtension.js'
import { isEqual } from "lodash";
import { BubbleMenu } from '@tiptap/extension-bubble-menu'

window.editors = []

export default function typist({state, statePath, placeholder, mergeTags = []}) {
    let editor

    return {
        updatedAt: Date.now(),
        state: state,
        statePath: statePath,
        placeholder: placeholder ?? "press '/' for blocks",
        fullscreen: false,
        isFocused: false,
        sidebarOpen: true,
        wordCount: 0,
        init() {
            const _this = this

            window.editors[statePath] = editor = new Editor({
                element: this.$refs.element,
                extensions: [
                    StatePathExtension.configure({
                        statePath: statePath
                    }),
                    DragAndDropExtension,
                    ClassExtension,
                    IdExtension,
                    StarterKit,
                    LinkExtension,
                    MediaExtension,
                    Grid,
                    GridColumn,
                    Details,
                    DetailsContent,
                    DetailsSummary,
                    Subscript,
                    Superscript,
                    Table.configure({
                        resizable: true,
                    }),
                    TableRow,
                    TableHeader,
                    TableCell,
                    TextAlignExtension.configure({
                        types: ['heading', 'paragraph']
                    }),
                    TextStyle,
                    Underline,
                    MergeTag.configure({
                        mergeTags
                    }),
                    BubbleMenu.configure({
                        element: _this.$refs.bubbleMenu,
                        tippyOptions: {
                            maxWidth: 'none',
                            placement: 'top',
                            theme: 'typist-bubble',
                            interactive: true,
                            appendTo: _this.$root,
                            zIndex: 10,
                        },
                        shouldShow: ({ editor, from, to }) => {
                            if (editor.isActive('link') || editor.isActive('media')) {
                                return true
                            }

                            return from !== to && ! (
                                editor.isActive('scribbleBlock') ||
                                editor.isActive('slashExtension')
                            )
                        },
                    })
                ],
                content: window.editors[statePath]?.getJSON() ?? this.state,
                onCreate({ editor }) {
                    _this.updatedAt = Date.now()
                    _this.wordCount = editor.getText().trim().split(' ').length;
                },
                onUpdate({ editor }) {
                    _this.updatedAt = Date.now()
                    _this.state = editor.getJSON()
                    _this.wordCount = editor.getText().trim().split(' ').length;
                },
                onSelectionUpdate({ editor }) {
                    _this.updatedAt = Date.now()
                    _this.$dispatch('selection-update')
                },
                onFocus({ editor }) {
                    _this.isFocused = editor.isFocused
                    _this.updatedAt = Date.now()
                }
            })

            this.$watch('isFocused', (value) => {
                if (value === false) {
                    this.$el.querySelectorAll('.is-active')?.forEach((item) => item.classList.remove('is-active'))
                }
            })

            this.$watch('state', (newState, oldState) => {
                if (typeof newState !== "undefined") {
                    if (! isEqual(oldState, Alpine.raw(newState))) {
                        editor.commands.focus()
                    }
                }
            });
        },
        isLoaded() {
            return window.editors[statePath] ?? editor;
        },
        handleAction(command, args = null) {
            editor.chain()[command](args).focus().run()
        },
        isActive(attrs) {
            return editor.isActive(attrs)
        },
        toggleFullscreen(event) {
            this.fullscreen = !this.fullscreen
            editor.commands.focus()
            this.updatedAt = Date.now()
        },
        toggleSidebar(event) {
            this.sidebarOpen = ! this.sidebarOpen
            editor.commands.focus()
            this.updatedAt = Date.now()
        },
        focusEditor(event) {
            let path = window.editors[event.detail.statePath].storage.statePathExtension.statePath
            if (event.detail.statePath === path) {
                setTimeout(() => window.editors[event.detail.statePath].commands.focus(), 200)
                this.updatedAt = Date.now()
            }
        },
        insertMergeTag(event) {
            editor.commands.insertMergeTag({
                tag: event.detail.tag,
                coordinates: event.detail.coordinates,
            });

            if (! editor.isFocused) {
                editor.commands.focus();
            }

            this.updatedAt = Date.now()
        },
    }
}
