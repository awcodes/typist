import { Editor } from '@tiptap/core'
import StatePath from './extensions/StatePath.js'
import Link from './extensions/Link.js'
import Classes from './extensions/Classes.js'
import Ids from './extensions/Ids.js'
import MergeTag from './extensions/MergeTag.js'
import DragAndDrop from './extensions/DragAndDrop.js'
import { Underline } from '@tiptap/extension-underline'
import { Subscript } from '@tiptap/extension-subscript'
import { Superscript } from '@tiptap/extension-superscript'
import TextAlign from './extensions/TextAlign.js'
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
import Media from './extensions/Media.js'
import { BubbleMenu } from '@tiptap/extension-bubble-menu'
import Block from './extensions/Block.js'
import SlashMenu from './extensions/SlashMenu.js'
import {Placeholder} from "@tiptap/extension-placeholder";
import {Document} from "@tiptap/extension-document";
import {Text} from "@tiptap/extension-text";
import {Paragraph} from "@tiptap/extension-paragraph";
import {Dropcursor} from "@tiptap/extension-dropcursor";
import {Gapcursor} from "@tiptap/extension-gapcursor";
import {HardBreak} from "@tiptap/extension-hard-break";
import {Heading} from "@tiptap/extension-heading";
import {Bold} from "@tiptap/extension-bold";
import {Italic} from "@tiptap/extension-italic";
import {Strike} from "@tiptap/extension-strike";
import {BulletList} from "@tiptap/extension-bullet-list";
import {OrderedList} from "@tiptap/extension-ordered-list";
import {Code} from "@tiptap/extension-code";
import {ListItem} from "@tiptap/extension-list-item";
import {History} from "@tiptap/extension-history";
import Lead from "./extensions/Lead.js";
import Small from "./extensions/Small.js";
import {Blockquote} from "@tiptap/extension-blockquote";
import CustomCommands from "./extensions/CustomCommands.js";
import {HorizontalRule} from "@tiptap/extension-horizontal-rule";
import CodeBlockLowlight from './extensions/CodeBlock.js'
import lowlight from "./extensions/Lowlight.js";
import {Color} from "@tiptap/extension-color";
import {Highlight} from "@tiptap/extension-highlight";

window.editors = [];
window.tiptapExtensions = [];

export default function typist({state, statePath, placeholder = null, mergeTags = [], suggestions = []}) {
    let editor

    return {
        updatedAt: Date.now(),
        state: state,
        statePath: statePath,
        placeholder: placeholder,
        fullscreen: false,
        isFocused: false,
        sidebarOpen: true,
        wordCount: 0,
        updatedFromEditor: false,
        init() {
            // TODO: figure out why this is necessary for Repeaters and Builders
            let existing = this.$refs.element.querySelector('.tiptap');
            if (existing) {
                existing.remove();
                editor = null;
            }

            if (editor) {
                this.state = editor.getJSON();
                editor = null;
            }

            const _this = this

            window.editors[this.statePath] = editor = new Editor({
                element: this.$refs.element,
                extensions: this.getExtensions(),
                content: this.state,
                editorProps: {
                    handlePaste(view, event, slice) {
                        slice.content.descendants(node => {
                            if (node.type.name === 'typistBlock') {
                                const parser = new DOMParser()
                                const doc = parser.parseFromString(node.attrs.view, 'text/html')
                                node.attrs.view = doc.documentElement.textContent
                            }
                        });
                    }
                },
                onCreate({ editor }) {
                    _this.wordCount = editor.getText().trim().split(' ').length;
                    _this.updatedAt = Date.now()
                },
                onUpdate({ editor }) {
                    window.dispatchEvent(new CustomEvent('updatedEditor', {
                        detail: {
                            statePath: _this.statePath,
                            content: editor.getJSON(),
                        }
                    }));
                    _this.wordCount = editor.getText().trim().split(' ').length;
                    _this.updatedAt = Date.now()
                },
                onSelectionUpdate({ editor }) {
                    _this.$dispatch('selection-update')
                    _this.updatedAt = Date.now()
                },
                onFocus({ editor }) {
                    _this.isFocused = editor.isFocused
                    _this.updatedAt = Date.now()
                }
            })

            let sortableEl = this.$el.parentElement.closest("[x-sortable]");
            if (sortableEl) {
                window.Sortable.utils.on(sortableEl, "start", () => {
                    sortableEl.classList.add('sorting')
                });

                window.Sortable.utils.on(sortableEl, "end", () => {
                    sortableEl.classList.remove('sorting')
                });
            }

            this.$watch('isFocused', (value) => {
                if (value === false) {
                    this.blurEditor()
                }
            })

            this.$watch('state', (newState, oldState) => {
                if (! this.updatedFromEditor && JSON.stringify(newState) !== JSON.stringify(oldState)) {
                    window.dispatchEvent(new CustomEvent('updateContent', {
                        detail: {
                            statePath: statePath,
                            newContent: newState,
                        }
                    }));

                    this.updatedFromEditor = false
                }
            });

            window.addEventListener('updatedEditor', event => {
                if (event.detail.statePath === this.statePath) {
                    this.updatedFromEditor = true
                    this.state = event.detail.content
                }
            })

            window.addEventListener('updateContent', event => {
                if (event.detail.statePath === this.statePath) {
                    editor.chain().setContent(event.detail.newContent).run()
                }
            })
        },
        editor() {
            return editor;
        },
        handleCommand(command, args = null) {
            editor.chain().focus()[command](args).run()
        },
        handleLivewire(actionName, data = {}) {
            data = {
                coordinates: editor.view.state.selection,
                ...data,
            }

            this.$wire.mountFormComponentAction(this.statePath, actionName, data)
        },
        handleSuggestion(event) {
            if (event.detail.statePath === editor.commands.getStatePath()) {
                if (event.detail.item.actionType === "alpine") {
                    this.$nextTick(() => {
                        editor
                            .chain()
                            .focus(event.detail.range.from)[event.detail.item.commandName](event.detail.item.commandAttributes)
                            .selectNodeForward()
                            .deleteSelection()
                            .setTextSelection(event.detail.range.to)
                            .run()
                    })
                } else {
                    this.$nextTick(() => {
                        editor
                            .chain()
                            .focus(event.detail.range.from)
                            .selectNodeForward()
                            .deleteSelection()
                            .setTextSelection(event.detail.range.from)
                            .run()
                    })

                    this.$wire.mountFormComponentAction(event.detail.statePath, event.detail.item.name, {coordinates: editor.view.state.selection});
                }
            }
        },
        isActive(name, attrs) {
            return editor.isActive(name, attrs)
        },
        toggleFullscreen() {
            this.fullscreen = !this.fullscreen
            editor.commands.focus()
            this.updatedAt = Date.now()
        },
        toggleSidebar() {
            this.sidebarOpen = ! this.sidebarOpen
            editor.commands.focus()
            this.updatedAt = Date.now()
        },
        focusEditor(event) {
            if (event.detail.statePath === this.editor().commands.getStatePath()) {
                setTimeout(() => this.editor().commands.focus(), 200)
                this.updatedAt = Date.now()
            }
        },
        blurEditor() {
            const tippy = this.$el.querySelectorAll('[data-tippy-content]')
            this.$el.querySelectorAll('.is-active')?.forEach((item) => item.classList.remove('is-active'))

            if (tippy) {
                tippy.forEach((item) => item.destroy())
            }

            this.isFocused = false
            this.updatedAt = Date.now()
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
        insertBlock(event) {
            this.handleLivewire(event.detail.name, {
                coordinates: event.detail.coordinates,
            })

            this.updatedAt = Date.now()
        },
        getExtensions() {
            const coreExtensions = [
                Block,
                BubbleMenu.configure({
                    element: this.$refs.bubbleMenu,
                    tippyOptions: {
                        duration: [500, 0],
                        maxWidth: 'none',
                        placement: 'top',
                        theme: 'typist-bubble',
                        interactive: true,
                        appendTo: this.$refs.element,
                        zIndex: 0,
                        arrow: false,
                    },
                    shouldShow: ({ editor, from, to }) => {
                        if (
                            editor.isActive('typistBlock') ||
                            editor.isActive('slashExtension')
                        ) {
                            return false
                        }

                        if (
                            editor.isActive('link') ||
                            editor.isActive('media')
                        ) {
                            return true
                        }
                    },
                }),
                Classes,
                CustomCommands,
                Document,
                DragAndDrop,
                Dropcursor,
                Gapcursor,
                HardBreak,
                History,
                Ids,
                MergeTag.configure({
                    mergeTags
                }),
                Paragraph,
                Placeholder.configure({
                    placeholder: this.placeholder
                }),
                SlashMenu.configure({
                    suggestions,
                    appendTo: this.$refs.element
                }),
                StatePath.configure({
                    statePath: statePath
                }),
                Text,
                TextStyle,
            ];

            return [
                ...coreExtensions,
                Blockquote,
                Bold,
                BulletList,
                Code,
                CodeBlockLowlight.configure({lowlight}),
                Color,
                Details,
                DetailsContent,
                DetailsSummary,
                Grid,
                GridColumn,
                Heading,
                Highlight,
                HorizontalRule,
                Italic,
                Lead,
                ListItem,
                Link,
                Media,
                OrderedList,
                Small,
                Strike,
                Subscript,
                Superscript,
                Table.configure({
                    resizable: true,
                }),
                TableRow,
                TableHeader,
                TableCell,
                TextAlign.configure({
                    types: ['heading', 'paragraph', 'media']
                }),
                Underline,
                ...window.tiptapExtensions,
            ]
        }
    }
}
