import { Favicon } from "@/models/Favicon";

export class Bookmark {
    public key: number;
    public icon: Favicon;
    public name: string;
    public url: string;

    constructor(
        name: string,
        url: string,
        favicon: Favicon | string | ArrayBuffer,
    ) {
        this.key = Math.random();
        this.name = name;
        this.url = url;
        this.icon = new Favicon(favicon);
    }
}
