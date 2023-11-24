<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <BaseButton :as="Link" :href="create_url">
            <template #leftIcon>
                <IconPlus class="fill-current w-4 h-4" />
            </template>
            Add New Bookmark
        </BaseButton>
    </aside>

    <div class="flex flex-col justify-start gap-2 z-50" ref="el">
        <BookmarkCategory
            v-for="category in bookmarkStore.categories"
            :category="category"
            :key="category"
            :bookmarks="bookmarkStore.bookmarks[category].data"
        />
    </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useSortable } from "@vueuse/integrations/useSortable";
import { useBookmarkStore } from "@/stores/bookmarks";
import { Link } from "@inertiajs/vue3";
import { Bookmark } from "@/types/bookmarks";
import IconPlus from "@/components/icons/IconPlus.vue";
import BaseButton from "@/components/BaseButton.vue";
import BookmarkCategory from "@/pages/bookmarks/components/BookmarkCategory.vue";
import App from "@/layouts/App.vue";

const props = defineProps<{
    bookmarks: Bookmark[];
    create_url: string;
    new_bookmark?: number;
}>();

const bookmarkStore = useBookmarkStore();
bookmarkStore.loadBookmarks(props.bookmarks);

const el = ref<HTMLElement | null>(null);
useSortable(el, bookmarkStore.categories, {
    animation: 200,
    handle: ".drag-handle-2",
});
</script>

<script lang="ts">
export default {
    Layout: App,
};
</script>
