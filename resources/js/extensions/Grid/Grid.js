import { callOrReturn, getExtensionField, Node, mergeAttributes } from '@tiptap/core'
import { TextSelection } from '@tiptap/pm/state'
import { createGrid } from './utils/createGrid.js'

export default Node.create({
    name: 'grid',
    group: 'block',
    defining: true,
    isolating: true,
    allowGapCursor: false,
    content: 'gridColumn+',
    gridRole: 'grid',
    addOptions() {
        return {
            HTMLAttributes: {
                class: 'typist-grid',
            },
        }
    },
    addAttributes() {
        return {
            'data-type': {
                default: 'symmetric',
                parseHTML: (element) => element.getAttribute('data-type'),
            },
            'data-columns': {
                default: 2,
                parseHTML: (element) => element.getAttribute('data-columns'),
            },
            'data-stack-at': {
                default: 'md',
                parseHTML: (element) => element.getAttribute('data-stack-at'),
            },
            'style': {
                default: null,
                parseHTML: (element) => element.getAttribute('style'),
                renderHTML: (attributes) => {
                    return {
                        style: `grid-template-columns: repeat(${attributes['data-columns']}, 1fr);`,
                    }
                },
            },
        }
    },
    parseHTML() {
        return [
            {
                tag: 'div',
                getAttrs: (node) => (node.classList.contains("typist-grid") && ! node.classList.contains("-column")) && null,
            },
        ]
    },
    renderHTML({ HTMLAttributes }) {
        return ['div', mergeAttributes(this.options.HTMLAttributes, HTMLAttributes), 0]
    },
    addCommands() {
        return {
            insertGrid:
                ({ columns = 2, stack_at, asymmetric, left_span = null, right_span = null, coordinates = null } = {}) =>
                    ({ tr, dispatch, editor }) => {
                        const node = createGrid(editor.schema, columns, stack_at, asymmetric, left_span, right_span)

                        if (dispatch) {
                            const offset = tr.selection.anchor + 1

                            if (! [null, undefined].includes(coordinates?.from)) {
                                tr.replaceRangeWith(coordinates.from, coordinates.to, node)
                                    .scrollIntoView()
                                    .setSelection(TextSelection.near(tr.doc.resolve(coordinates.from)))
                            } else {
                                tr.replaceSelectionWith(node)
                                    .scrollIntoView()
                                    .setSelection(TextSelection.near(tr.doc.resolve(offset)))
                            }
                        }

                        return true
                    },
        }
    },
    extendNodeSchema(extension) {
        return {
            gridRole: callOrReturn(getExtensionField(extension, 'gridRole', {
                name: extension.name,
                options: extension.options,
                storage: extension.storage,
            })),
        }
    },
})
