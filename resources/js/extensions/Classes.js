import {Extension} from '@tiptap/core'

export default Extension.create({
    name: 'classes',

    addGlobalAttributes() {
        return [
            {
                types: [
                    'heading',
                    'paragraph',
                    'link',
                    'image',
                    'listItem',
                    'bulletList',
                    'orderedList',
                    'table',
                    'tableHeader',
                    'tableRow',
                    'tableCell',
                    'textStyle',
                ],
                attributes: {
                    class: {
                        default: null,
                        parseHTML: element => element.getAttribute('class') ?? null,
                        renderHTML: attributes => {
                            if (!attributes.class) {
                                return null;
                            }
                            return {
                                class: attributes.class
                            }
                        },
                    },
                },
            },
        ]
    }
})
