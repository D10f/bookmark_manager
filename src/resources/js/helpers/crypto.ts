import { makeFetch } from "@/helpers/api";

export default class PublicCrypto {
    private keys: CryptoKeyPair | null = null;

    private uploadPublicKeyRequest: (
        options?: RequestInit,
    ) => Promise<Response>;

    private keyBasedAuthenticationRequest: (
        options?: RequestInit,
    ) => Promise<Response>;

    constructor() {
        this.uploadPublicKeyRequest = makeFetch("/api/user/add-key", "post");
        this.keyBasedAuthenticationRequest = makeFetch("/login-key", "post");
    }

    base64Encode(buffer: ArrayBuffer) {
        const keyString = String.fromCharCode.apply(
            null,
            new Uint8Array(buffer) as unknown as number[],
        );

        return btoa(keyString);
    }

    formatAsPEM(key: string | ArrayBuffer, type: "public" | "private") {
        let _key = key;

        if (typeof _key !== "string") {
            _key = this.base64Encode(_key);
        }

        const wrapper =
            type === "public"
                ? `-----BEGIN PUBLIC KEY-----`
                : `-----BEGIN PRIVATE KEY-----`;

        return `${wrapper}\n${_key}\n${wrapper.replace("BEGIN", "END")}`;
    }

    private async generateKeyPair() {
        this.keys = await crypto.subtle.generateKey(
            {
                name: "RSASSA-PKCS1-v1_5",
                modulusLength: 4096,
                publicExponent: new Uint8Array([1, 0, 1]),
                hash: "SHA-256",
            },
            true,
            ["sign"],
        );
    }

    async privateKey() {
        if (!this.keys) {
            await this.generateKeyPair();
        }

        return await crypto.subtle.exportKey("pkcs8", this.keys!.privateKey);
    }

    async publicKey() {
        if (!this.keys) {
            await this.generateKeyPair();
        }

        return await crypto.subtle.exportKey("spki", this.keys!.publicKey);
    }

    // Sign some data
    // let encoded = new TextEncoder().encode(page.props.auth.user?.id);
    // let signature = await window.crypto.subtle.sign(
    //     {
    //         name: "RSASSA-PKCS1-v1_5",
    //         hash: "SHA-256",
    //     },
    //     cryptoPair.keys!.privateKey,
    //     encoded,
    // );

    // const res = await fetch("/api/test", {
    //     method: "POST",
    //     headers: {
    //         Accept: "application/json",
    //         "Content-Type": "application/json",
    //         "X-XSRF-TOKEN": getCookie("XSRF-TOKEN"),
    //     },
    //     body: JSON.stringify({
    //         key: cryptoPair.base64Encode(publicKey),
    //         sig: new Uint8Array(signature).toString(),
    //     }),
    // });
    async sign(
        data: string | ArrayBuffer | Uint8Array,
        key: CryptoKey,
        serialize = true,
    ) {
        let encoded = data;

        if (!data) {
            throw new Error("Invalid data argument provided.");
        }

        if (!key) {
            throw new Error("Invalid crypto key argument provided.");
        }

        if (typeof encoded === "string") {
            encoded = new TextEncoder().encode(encoded);
        }

        const buffer = await window.crypto.subtle.sign(
            {
                name: "RSASSA-PKCS1-v1_5",
                hash: "SHA-256",
            },
            key,
            encoded,
        );

        return serialize ? new Uint8Array(buffer).toString() : buffer;
    }

    async uploadPublicKey() {
        const res = await this.uploadPublicKeyRequest({
            body: JSON.stringify({
                key: this.base64Encode(await this.publicKey()),
            }),
        });

        if (!res.ok) {
            throw new Error(`Public key upload failed (${res.statusText}).`);
        }

        return await res.json();
    }

    async downloadPrivateKey() {
        // TODO
    }
}
