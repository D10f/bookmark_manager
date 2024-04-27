export default class BookmarkParser {
    async parse(bookmarkFile: File, bookmarkMap = { bookmarks: [] }) {
        const rootNode = await this.read(bookmarkFile);
        this._parse(rootNode as Node, bookmarkMap);
        return bookmarkMap;
    }

    private _parse(root: Node, tree: Record<string, any>) {
        for (const node of root.childNodes) {
            if (node.nodeName != "DT") continue;

            const nextNode = this.peek(node);

            if (!nextNode) continue;

            if (nextNode.type === "category") {
                const dl = (node as HTMLElement).querySelector("dl")!;
                tree[nextNode.title] = {
                    bookmarks: nextNode.bookmarks,
                };
                this._parse(dl, tree[nextNode.title]);
            } else if (nextNode.type === "bookmark") {
                tree.bookmarks.push({
                    title: nextNode.title,
                    url: nextNode.url,
                });
            }
        }
    }

    private peek(node: Node) {
        const nextNode = node.childNodes[0] as HTMLElement;

        if (nextNode.nodeName === "H3") {
            return {
                type: "category",
                title: nextNode.textContent as string,
                bookmarks: [],
            };
        }

        if (nextNode.nodeName === "A") {
            return {
                type: "bookmark",
                title: nextNode.textContent as string,
                url: nextNode.getAttribute("HREF"),
            };
        }

        return null;
    }

    private read(bookmarkFile: File) {
        const reader = new FileReader();

        return new Promise((resolve, reject) => {
            reader.onload = () => {
                if (typeof reader.result !== "string") {
                    return reader.abort();
                }

                if (
                    !reader.result.startsWith(
                        "<!DOCTYPE NETSCAPE-Bookmark-file-1>",
                    )
                ) {
                    return reject("Invalid file declaration.");
                }

                const parser = new DOMParser();
                const doc = parser.parseFromString(reader.result, "text/html");
                resolve(doc.querySelector("dl"));
            };

            reader.onabort = () => reject("Error reading file.");

            reader.readAsText(bookmarkFile);
        });
    }
}
