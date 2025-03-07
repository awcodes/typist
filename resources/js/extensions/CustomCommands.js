import {Extension} from '@tiptap/core'

export default Extension.create({
    name: 'customCommands',
    addCommands() {
        return {
            moveToEnd: () => ({chain, state, dispatch})  => {
                if (state.selection.empty) return false;

                return chain().setTextSelection(state.selection.$to.pos).run();
            }
        }
    }
})
