import { computed } from "vue";
import { defineStore } from "pinia";
import { useCategoryStore } from "./category";

export type BookmarkSearchResult = Pick<App.Models.Bookmark, "name" | "url"> & {
    path: string;
};

export const useBookmarkStore = defineStore("bookmark", () => {
    const categoryStore = useCategoryStore();

    const bookmarks = computed(() => {
        const results: BookmarkSearchResult[] = [];

        for (const category of categoryStore.categories) {
            const path = categoryStore.categoryFQDN(category).join("/");
            for (const { name, url } of category.bookmarks) {
                results.push({ path, name, url });
            }
        }

        return results;
    });

    return { bookmarks };
});
