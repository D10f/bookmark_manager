export class Favicon {
    constructor(public buffer: ArrayBuffer) { }

    get icon() {
        const blob = new Blob([this.buffer]);
        const iconUrl = URL.createObjectURL(blob);
        const icon = new Image();
        icon.src = iconUrl;
        URL.revokeObjectURL(iconUrl);
        return icon;
    }
}

// export class Favicon {
//     private src: string | ArrayBuffer;

//     constructor(input: Favicon | string | ArrayBuffer) {
//         this.src = input instanceof Favicon ? input.src : input;
//     }

//     get isSVG() {
//         return typeof this.src === "string";
//     }

//     get isBlob() {
//         return !this.isSVG;
//     }

//     get buffer() {
//         if (this.isSVG) return this.src as string;
//         const blob = new Blob([this.src]);
//         const imageBlob = URL.createObjectURL(blob);
//         setTimeout(() => URL.revokeObjectURL(imageBlob), 0);
//         return imageBlob;
//     }
// }
