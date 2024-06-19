import { Node, NodePos } from '@tiptap/core'

export default Node.create({
    name: 'typistBlock',
    isBlock: true,
    inline: false,
    group: 'block',
    draggable: true,
    defining: true,
    selectable: true,

    addAttributes() {
        return {
            identifier: {
                default: null
            },
            values: {
                default: {}
            },
            view: {
                default: null
            }
        };
    },

    parseHTML() {
        return [
            {
                tag: 'typist-block',
                getAttrs: (dom) => {
                    return JSON.parse(dom.innerHTML);
                },
            },
        ];
    },

    renderHTML({ HTMLAttributes }) {
        return ['typist-block', JSON.stringify(HTMLAttributes)];
    },

    addCommands() {
        return {
            insertBlock: (attributes) => {
                return ({ chain, state }) => {
                    const currentChain = chain()

                    if (! [null, undefined].includes(attributes.coordinates?.pos)) {
                        currentChain.insertContentAt({ from: attributes.coordinates.pos, to: attributes.coordinates.pos }, { type: this.name, attrs: attributes })

                        return currentChain.setTextSelection(attributes.coordinates.pos)
                    }

                    const { selection } = state
                    const { $from, $to } = selection

                    const range = $from.blockRange($to)

                    if (!range) {
                        if ($to.parentOffset === 0) {
                            currentChain
                                .insertContentAt(Math.max($to.pos - 1, 0), { type: 'paragraph' })
                                .insertContentAt({ from: $from.pos, to: $to.pos }, { type: this.name, attrs: attributes })
                        } else {
                            currentChain
                                .setNode({ type: 'paragraph' })
                                .insertContentAt({ from: $from.pos, to: $to.pos }, { type: this.name, attrs: attributes })
                        }

                        return currentChain.setTextSelection($to.pos + 1)
                    } else {
                        if ($to.parentOffset === 0) {
                            currentChain.insertContentAt(Math.max($to.pos - 1, 0), { type: this.name, attrs: attributes })
                        } else {
                            currentChain.insertContentAt({ from: range.start, to: range.end }, { type: this.name, attrs: attributes })
                        }

                        return currentChain.setTextSelection(range.end)
                    }
                }
            },
            updateBlock: (attributes) => ({ chain, state }) => {
                const { selection } = state
                const { $from, $to } = selection
                const range = $from.blockRange($to)
                const currentChain = chain()

                if (!range) {
                    currentChain.insertContentAt({ from: $from.pos, to: $from.pos + 1 }, { type: this.name, attrs: attributes })
                    return false
                }

                currentChain.insertContentAt({ from: range.start, to: range.end }, { type: this.name, attrs: attributes })

                return currentChain.focus(range.end + 1)
            },
            removeBlock: () => ({ commands }) => {
                return commands.deleteSelection()
            }
        }
    },

    addNodeView() {
        return ({ node }) => {
            const container = document.createElement('div')

            let data = encodeURIComponent(JSON.stringify(node.attrs.values));

            const controls = `
                <div x-data="{disabled: true}" x-on:click="disabled = false" x-on:click.away="disabled = true">
                    <div class="typist-block-controls" x-show="!disabled" x-cloak>
                        <button type="button" x-bind:disabled="disabled" x-on:click="handleLivewire('${node.attrs.identifier}', JSON.parse(decodeURIComponent('${data}')))">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                              <path d="M2 11.9998C2 11.1353 2.1097 10.2964 2.31595 9.49631C3.40622 9.55283 4.48848 9.01015 5.0718 7.99982C5.65467 6.99025 5.58406 5.78271 4.99121 4.86701C6.18354 3.69529 7.66832 2.82022 9.32603 2.36133C9.8222 3.33385 10.8333 3.99982 12 3.99982C13.1667 3.99982 14.1778 3.33385 14.674 2.36133C16.3317 2.82022 17.8165 3.69529 19.0088 4.86701C18.4159 5.78271 18.3453 6.99025 18.9282 7.99982C19.5115 9.01015 20.5938 9.55283 21.6841 9.49631C21.8903 10.2964 22 11.1353 22 11.9998C22 12.8643 21.8903 13.7032 21.6841 14.5033C20.5938 14.4468 19.5115 14.9895 18.9282 15.9998C18.3453 17.0094 18.4159 18.2169 19.0088 19.1326C17.8165 20.3043 16.3317 21.1794 14.674 21.6383C14.1778 20.6658 13.1667 19.9998 12 19.9998C10.8333 19.9998 9.8222 20.6658 9.32603 21.6383C7.66832 21.1794 6.18354 20.3043 4.99121 19.1326C5.58406 18.2169 5.65467 17.0094 5.0718 15.9998C4.48848 14.9895 3.40622 14.4468 2.31595 14.5033C2.1097 13.7032 2 12.8643 2 11.9998ZM6.80385 14.9998C7.43395 16.0912 7.61458 17.3459 7.36818 18.5236C7.77597 18.8138 8.21005 19.0652 8.66489 19.2741C9.56176 18.4712 10.7392 17.9998 12 17.9998C13.2608 17.9998 14.4382 18.4712 15.3351 19.2741C15.7899 19.0652 16.224 18.8138 16.6318 18.5236C16.3854 17.3459 16.566 16.0912 17.1962 14.9998C17.8262 13.9085 18.8225 13.1248 19.9655 12.7493C19.9884 12.5015 20 12.2516 20 11.9998C20 11.7481 19.9884 11.4981 19.9655 11.2504C18.8225 10.8749 17.8262 10.0912 17.1962 8.99982C16.566 7.90845 16.3854 6.65378 16.6318 5.47605C16.224 5.18588 15.7899 4.93447 15.3351 4.72552C14.4382 5.52844 13.2608 5.99982 12 5.99982C10.7392 5.99982 9.56176 5.52844 8.66489 4.72552C8.21005 4.93447 7.77597 5.18588 7.36818 5.47605C7.61458 6.65378 7.43395 7.90845 6.80385 8.99982C6.17376 10.0912 5.17754 10.8749 4.03451 11.2504C4.01157 11.4981 4 11.7481 4 11.9998C4 12.2516 4.01157 12.5015 4.03451 12.7493C5.17754 13.1248 6.17376 13.9085 6.80385 14.9998ZM12 14.9998C10.3431 14.9998 9 13.6567 9 11.9998C9 10.343 10.3431 8.99982 12 8.99982C13.6569 8.99982 15 10.343 15 11.9998C15 13.6567 13.6569 14.9998 12 14.9998ZM12 12.9998C12.5523 12.9998 13 12.5521 13 11.9998C13 11.4475 12.5523 10.9998 12 10.9998C11.4477 10.9998 11 11.4475 11 11.9998C11 12.5521 11.4477 12.9998 12 12.9998Z"/>
                            </svg>
                        </button>
                    </div>
                    ${node.attrs.view}
                </div>
            `

            container.classList.add('relative')
            container.setAttribute('data-typist-block', 'true')

            container.innerHTML = controls

            return {
                dom: container,
            }
        }
    },
})
