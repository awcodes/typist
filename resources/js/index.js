import { Editor } from '@tiptap/core'
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
import Block from './extensions/Block.js'
import SlashExtension from './extensions/SlashExtension.js'
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
import {CodeBlock} from "@tiptap/extension-code-block";
import {ListItem} from "@tiptap/extension-list-item";

window.editors = [];

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
                                node.attrs.statePath = _this.statePath
                                node.attrs.data = JSON.parse(node.attrs.data)
                            }
                        });
                    }
                },
                onCreate({ editor }) {
                    _this.wordCount = editor.getText().trim().split(' ').length;
                    _this.updatedAt = Date.now()
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

            let sortableEl = this.$el.parentElement.closest("[x-sortable]");
            if (sortableEl) {
                window.Sortable.utils.on(sortableEl, "start", () => {
                    let editors = document.querySelectorAll('.typist-wrapper');

                    if (editors.length === 0) return;

                    editors.forEach((editor) => {
                        editor._x_dataStack[0].editor().setEditable(false);
                        editor._x_dataStack[0].editor().options.element.style.pointerEvents = 'none';
                    });
                });

                window.Sortable.utils.on(sortableEl, "end", () => {
                    let editors = document.querySelectorAll('.typist-wrapper');

                    if (editors.length === 0) return;

                    editors.forEach((editor) => {
                        editor._x_dataStack[0].editor().setEditable(true);
                        editor._x_dataStack[0].editor().options.element.style.pointerEvents = 'all';
                    });
                });
            }

            this.$watch('isFocused', (value) => {
                if (value === false) {
                    this.blurEditor()
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
        editor() {
            return editor;
        },
        handleCommand(command, args = null) {
            editor.chain().focus()[command](args).run()
        },
        handleLivewire(actionName, data = {}) {
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

                    this.$wire.mountFormComponentAction(event.detail.statePath, event.detail.item.name);
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
            return [
                Block,
                Bold,
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
                BulletList,
                ClassExtension,
                Code,
                CodeBlock,
                Details,
                DetailsContent,
                DetailsSummary,
                Document,
                DragAndDropExtension,
                Dropcursor,
                Gapcursor,
                Grid,
                GridColumn,
                HardBreak,
                Heading,
                History,
                IdExtension,
                Italic,
                ListItem,
                LinkExtension,
                MediaExtension,
                MergeTag.configure({
                    mergeTags
                }),
                OrderedList,
                Paragraph,
                Placeholder.configure({
                    placeholder: this.placeholder
                }),
                SlashExtension.configure({
                    suggestions,
                    appendTo: this.$refs.element
                }),
                StatePathExtension.configure({
                    statePath: statePath
                }),
                Strike,
                Subscript,
                Superscript,
                Table.configure({
                    resizable: true,
                }),
                TableRow,
                TableHeader,
                TableCell,
                Text,
                TextAlignExtension.configure({
                    types: ['heading', 'paragraph']
                }),
                TextStyle,
                Underline,
            ]
        }
    }
}
