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

export const isValidVimeoUrl = (url) => {
    return url.match(/(vimeo\.com)(.+)?$/);
};

export const getVimeoEmbedUrl = (options) => {
    // if is already an embed url, return it
    if (options.src.includes("/video/")) {
        return options.src;
    }

    const videoIdRegex = /\.com\/([0-9]+)/gm;
    const matches = videoIdRegex.exec(options.src);

    if (!matches || !matches[1]) {
        return null;
    }

    let outputUrl = `https://player.vimeo.com/video/${matches[1]}`;

    let params = [];

    if (Object.values(options.options).length > 0) {
        for (const [key, value] of Object.entries(options.options)) {
            params.push(`${key}=${value}`);
        }

        outputUrl += `?${params.join("&")}`;
    }

    return outputUrl;
};

export const isValidYoutubeUrl = (url) => {
    return url.match(/(youtube\.com|youtu\.be)(.+)?$/);
};

export const getYouTubeEmbedUrl = (options) => {
    const embedUrl = options.options.nocookie ? "https://www.youtube-nocookie.com/embed/" : "https://www.youtube.com/embed/";
    delete options.options.nocookie

    // if is already an embed url, return it
    if (options.src.includes("/embed/")) {
        return options.src;
    }

    // if is a youtu.be options.src, get the id after the /
    if (options.src.includes("youtu.be")) {
        const id = options.src.split("/").pop();

        if (!id) {
            return null;
        }
        return `${embedUrl}${id}`;
    }

    const videoIdRegex = /v=([-\w]+)/gm;
    const matches = videoIdRegex.exec(options.src);

    if (!matches || !matches[1]) {
        return null;
    }

    let outputUrl = `${embedUrl}${matches[1]}`;
    let params = [];

    if (Object.values(options.options).length > 0) {
        for (const [key, value] of Object.entries(options.options)) {
            params.push(`${key}=${value}`);
        }

        outputUrl += `?${params.join("&")}`;
    }

    return outputUrl;
};
