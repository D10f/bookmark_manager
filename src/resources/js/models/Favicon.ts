export class Favicon {
    private src: string | ArrayBuffer;

    constructor(input: Favicon | string | ArrayBuffer) {
        this.src = input instanceof Favicon ? input.src : input;
    }

    get isSVG() {
        return typeof this.src === "string";
    }

    get isBlob() {
        return !this.isSVG;
    }

    get buffer() {
        if (this.isSVG) return this.src as string;
        const blob = new Blob([this.src]);
        const imageBlob = URL.createObjectURL(blob);
        setTimeout(() => URL.revokeObjectURL(imageBlob), 0);
        return imageBlob;
    }
}
