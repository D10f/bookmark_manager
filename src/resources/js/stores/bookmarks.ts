import { defineStore } from "pinia";
import { Bookmark } from "@/models/Bookmark";
import { computed, ref } from "vue";

export type BookmarkGroup = {
    order: number;
    collapsed: boolean;
    data: Bookmark[];
};

export const useBookmarkStore = defineStore("bookmark", () => {
    // const bookmarks = ref<Record<string, BookmarkGroup>>({
    //     Entertainment: {
    //         order: 1,
    //         collapsed: false,
    //         data: [],
    //     },
    //     Search: {
    //         order: 2,
    //         collapsed: false,
    //         data: [],
    //     },
    //     Documentation: {
    //         order: 3,
    //         collapsed: false,
    //         data: [],
    //     },
    // });

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
