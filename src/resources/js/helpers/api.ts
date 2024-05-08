export function getCookie(key: string) {
    const re = new RegExp(`${key}=([^;]+)`);
    const cookie = document.cookie.match(re);
    return cookie ? decodeURIComponent(cookie[1]) : "";
}

function authFetchFactory(token: string) {
    return function resourceHandlerFactory(url: string, method: string) {
        return function resourceHandler(options: RequestInit = {}) {
            options.method = method;
            options.headers = {
                ...(options.headers || {}),
                "Content-Type": "application/json",
                "X-XSRF-TOKEN": token,
            };
            return fetch(url, options);
        };
    };
}

export const makeFetch = authFetchFactory(getCookie("XSRF-TOKEN"));
