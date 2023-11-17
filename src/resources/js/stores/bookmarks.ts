import { computed, ref } from "vue";
import { defineStore } from "pinia";
import { Bookmark } from "@/types/Bookmark";

export type BookmarkGroup = {
    order: number;
    collapsed: boolean;
    data: Bookmark[];
};

export const useBookmarkStore = defineStore("bookmark", () => {
    const bookmarks = ref<Record<string, BookmarkGroup>>({});

    const categories = computed(() => Object.keys(bookmarks.value));

    const totalCategories = computed(() => categories.value.length);

    async function createBookmark(bookmark: Bookmark, category: string) {
        const bookmarkBox = bookmarks.value[category];

        if (!bookmarkBox) {
            bookmarks.value[category] = {
                order: totalCategories.value,
                collapsed: false,
                data: [bookmark],
            };
            return;
        }

        bookmarkBox.data.push(bookmark);
    }

    return { bookmarks, categories, totalCategories, createBookmark };
});
