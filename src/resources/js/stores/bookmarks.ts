import { defineStore } from "pinia";
import {
    documentationBookmarks,
    entertainmentBookmarks,
    searchEngineBookmarks,
} from "./data";
import { Bookmark } from "@/models/Bookmark";

type BookmarkGroup = {
    title: string;
    order: number;
    collapsed: boolean;
    data: Bookmark[];
};

type BookmarkState = {
    bookmarks: BookmarkGroup[];
};

export const useBookmarkStore = defineStore("bookmark", {
    state: (): BookmarkState => ({
        bookmarks: [
            {
                title: "Entertainment",
                order: 1,
                collapsed: false,
                data: entertainmentBookmarks,
            },
            {
                title: "Search",
                order: 2,
                collapsed: false,
                data: searchEngineBookmarks,
            },
            {
                title: "Docs",
                order: 3,
                collapsed: false,
                data: documentationBookmarks,
            },
        ],
    }),

    actions: {
        async create(bookmark: Bookmark, category: string) {
            let bookmarkBox = this.bookmarks.find((b) => b.title === category);

            if (!bookmarkBox) {
                this.bookmarks.push({
                    title: category,
                    collapsed: false,
                    order: 1,
                    data: [bookmark],
                });

                return;
            }

            bookmarkBox.data.push(bookmark);
        },
        async update() { },
        async delete() { },
    },

    getters: {
        categories(state) {
            return state.bookmarks.map((b) => b.title);
        },
    },
});
