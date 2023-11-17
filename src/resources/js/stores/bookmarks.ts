import { computed, ref } from "vue";
import { defineStore } from "pinia";
import { Bookmark, BookmarkCategoryType } from "@/types/bookmarks";

export const useBookmarkStore = defineStore("bookmark", () => {
    const bookmarks = ref<Record<string, BookmarkCategoryType>>({});

    const categories = computed(() => Object.keys(bookmarks.value));

    const totalCategories = computed(() => categories.value.length);

    function loadBookmarks(newBookmarks: Bookmark[]) {
        bookmarks.value = newBookmarks.reduce(
            (acc, curr) => {
                if (acc[curr.category]) {
                    acc[curr.category].data.push(curr);
                } else {
                    acc[curr.category] = {
                        order: 1,
                        collapsed: false,
                        data: [curr],
                    };
                }

                return acc;
            },
            {} as Record<string, BookmarkCategoryType>,
        );
    }

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

    return {
        bookmarks,
        categories,
        totalCategories,
        loadBookmarks,
        createBookmark,
    };
});
