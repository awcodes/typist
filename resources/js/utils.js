export function convertValues(payload) {
    let string = '{'
    const keys = Object.keys(payload)
    const values = Object.values(payload)
    values.forEach((value, index) => {
        if (value && typeof value === 'object') {
            convertValues(value)
        } else {
            const newValue = value ? `\u0022${value}\u0022` : value
            string += `${keys[index]}: ${newValue},`
        }
    })
    string += '}'
    return string;
}
