interface IBookmark {
    key: number;
    icon: string;
    name: string;
    url: string;
}

export class Bookmark implements IBookmark {
    public key: number;
    public icon: string;

    constructor(
        public name: string,
        public url: string,
    ) {
        this.key = Math.random();
        this.fetchFavicon();
    }

    async fetchFavicon() {
        const url = `https://icons.duckduckgo.com/ip3/${this.url}.ico`;

        const response = await fetch(url);
        const html = await response.text();
        console.log(html);

        if (!html) {
            this.icon = "";
            return;
        }

        const faviconUrls = html
            .match(/<link rel="icon"[^>]*href="([^>]*)"/g)
            .map((res) => res.match(/href="(.*)"/)[1]);

        if (faviconUrls.length === 0) {
            console.log("Go fish!");
            return "";
        }

        faviconUrls.forEach((url) => console.log(url));
        return this.url + faviconUrls[0];
    }

    imageToBase64() { }
}
