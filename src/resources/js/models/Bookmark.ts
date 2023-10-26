import { extractDomain } from "@/shared/helpers/urlExtractor";

export class Bookmark {
    public key: number;
    public iconUrl: string;

    constructor(
        public name: string,
        public url: string,
    ) {
        this.key = Math.random();
        this.iconUrl = `/storage/favicons/${extractDomain(url)}/favicon.ico`;
    }

    // get icon() {
    //     if (this._icon) return this._icon;
    //     if (this._icon === null) return null;

    //     const domain = ;
    //     let iconUrl = "";

    //     try {
    //         return fetch(`/api/favicon/${domain}`)
    //             .then((response) => response.arrayBuffer())
    //             .then((buffer) => {
    //                 const blob = new Blob([buffer]);
    //                 iconUrl = URL.createObjectURL(blob);
    //                 return iconUrl;
    //             });
    //     } catch (e) {
    //         this._icon = null;
    //     } finally {
    //         setTimeout(() => {
    //             URL.revokeObjectURL(iconUrl);
    //         }, 0);
    //     }
    // }

    // get hasIcon() {
    //     return Boolean(this.icon);
    // }
}
