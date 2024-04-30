import { midString } from "./lexicographic";

export class BookmarkParser {
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
                const lastItem = tree.bookmarks[tree.bookmarks.length - 1];
                const lastItemOrder = lastItem ? lastItem.order : "";

                tree.bookmarks.push({
                    title: nextNode.title,
                    url: nextNode.url,
                    order: midString(lastItemOrder, ""),
                });
            }
        }
    }

    private peek(node: Node) {
        const nextNode = node.childNodes[0] as HTMLElement;

        if (nextNode.nodeName !== "H3" && nextNode.nodeName !== "A") {
            return null;
        }

        const title = nextNode.textContent as string;
        if (nextNode.nodeName === "H3") {
            return {
                type: "category",
                title: title || "Empty Folder",
                bookmarks: [],
            };
        }

        const url = nextNode.getAttribute("HREF") as string;
        return {
            type: "bookmark",
            title: title || url,
            url,
        };
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

export class BookmarkExporter {
    private document: Document;

    constructor(private bookmarkData: App.Models.Category[]) {
        this.document = new DOMParser().parseFromString(
            `<!DOCTYPE NETSCAPE-Bookmark-file-1>
            <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
            <TITLE>Bookmarks</TITLE>
            <H1>Bookmarks</H1>
            <DL><p></DL><p>`,
            "text/html",
        );
    }

    export() {
        this.bookmarkData
            .filter((category) => category.parent_id === null)
            .forEach((c) => {
                const node = this.makeCategoryMarkup(c);
                this.document.querySelector("dl")?.appendChild(node);
            });
        return this.document;
    }

    private makeCategoryMarkup(category: App.Models.Category) {
        const dt = this.document.createElement("dt");
        const h3 = this.document.createElement("h3");
        h3.textContent = category.title;
        dt.appendChild(h3);

        const dl = this.document.createElement("dl");
        const p = this.document.createElement("p");
        dl.appendChild(p);

        category.bookmarks.forEach((bookmark) => {
            const bookmarkDT = this.document.createElement("dt");
            const a = this.document.createElement("a");
            a.href = bookmark.url;
            a.textContent = bookmark.name;
            bookmarkDT.appendChild(a);
            dl.appendChild(bookmarkDT);
        });

        this.bookmarkData
            .filter((c) => c.parent_id === category.id)
            .map(this.makeCategoryMarkup.bind(this))
            .forEach((childCategory) => {
                dl.insertAdjacentElement("afterbegin", childCategory);
            });

        dt.insertAdjacentElement("beforeend", dl);
        return dt;
    }
}
