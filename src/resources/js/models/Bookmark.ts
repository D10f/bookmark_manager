import { extractDomain } from "@/shared/helpers/urlExtractor";

export class Bookmark {
    constructor(
        public name: string,
        public url: string,
        public id: string,
        public category: string,
    ) {}

    get iconUrl() {
        const domain = extractDomain(this.url);
        return `/storage/favicons/${domain}.png`;
    }
}
