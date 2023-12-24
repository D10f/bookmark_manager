import { computed, ref } from "vue";
import { defineStore } from "pinia";
import { useCategoryStore } from "./category";

export type BookmarkSearchResult = Pick<
    App.Models.Bookmark,
    "id" | "name" | "url"
> & {
    path: string;
};

export const useBookmarkStore = defineStore("bookmark", () => {
    const categoryStore = useCategoryStore();
    const bookmarks = ref<any[]>([]);

    function loadBookmarks() {
        const results: BookmarkSearchResult[] = [];

        for (const category of categoryStore.categories) {
            const path = categoryStore.categoryFQDN(category).join(" / ");
            for (const { id, name, url } of category.bookmarks) {
                results.push({ id, path, name, url });
            }
        }

        bookmarks.value = results;
    }
    // const bookmarks = computed(() => {
    //     const results: BookmarkSearchResult[] = [];

    //     for (const category of categoryStore.categories) {
    //         const path = categoryStore.categoryFQDN(category).join(" / ");
    //         for (const { id, name, url } of category.bookmarks) {
    //             results.push({ id, path, name, url });
    //         }
    //     }

    //     return results;
    // });

    return { bookmarks, loadBookmarks };
});
