export function extractDomain(url: string) {
    const result = url.match(
        /^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n]+)/im,
    );

    if (!result) throw new Error("Invalid URL provided.");

    return result[1];
}

export function extractProtocol(url: string, defaultProtocol = "https://") {
    const result = url.match(
        /^(https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?(?:[^:\/\n]+)/im,
    );

    return (result && result[1]) ?? defaultProtocol;
}

export function makeCanonical(url: string) {
    const domain = extractDomain(url);
    const protocol = extractProtocol(url);
    return protocol + domain;
}

export function buildUrl(url: string) {
    return url.match(/^https?:\/\/.+$/) ? url : `https://${url}`;
}
