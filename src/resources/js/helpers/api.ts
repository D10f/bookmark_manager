export function getCookie(key: string) {
    const re = new RegExp(`${key}=([^;]+)`);
    const cookie = document.cookie.match(re);
    return cookie ? decodeURIComponent(cookie[1]) : "";
}

export function authFetchFactory(token: string) {
    return function resourceHandlerFactory(url: string) {
        return function resourceHandler(options: RequestInit = {}) {
            options.headers = {
                ...(options.headers || {}),
                "Content-Type": "application/json",
                "X-XSRF-TOKEN": token,
            };
            return fetch(url, options);
        };
    };
}
