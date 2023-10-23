export class Bookmark {
    public key: number;
    private _icon: ArrayBuffer | undefined;
    public name: string;
    public url: string;

    constructor(name: string, url: string, icon?: ArrayBuffer) {
        this.key = Math.random();
        this.name = name;
        this.url = url.includes("http") ? url : `https://${url}`;
        this._icon = icon;
    }

    get icon() {
        if (!this._icon) {
            return undefined;
        }
        const blob = new Blob([this._icon]);
        const iconUrl = URL.createObjectURL(blob);
        setTimeout(() => {
            URL.revokeObjectURL(iconUrl);
        }, 0);
        return iconUrl;
    }

    get hasIcon() {
        return Boolean(this.icon);
    }
}
