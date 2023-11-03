<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <ButtonLink :to="create_url">
            <IconPlus class="group-hover:fill-slate-950 fill-white w-4 h-4 mr-2" />
            Add New Bookmark
        </ButtonLink>
    </aside>

    <BookmarkCategory v-for="category in bookmarkStore.categories" :category="category" :key="category">
        <BookmarkItem v-for="bookmark in bookmarkStore.bookmarks[category].data" :bookmark="bookmark" :key="bookmark.id" />
    </BookmarkCategory>
</template>

<script setup lang="ts">
import IconPlus from "@/shared/components/icons/IconPlus.vue";
import ButtonLink from "@/shared/components/ButtonLink.vue";
import { useBookmarkStore } from "@/stores/bookmarks";
import BookmarkCategory from "@/pages/bookmarks/components/BookmarkCategory.vue";
import BookmarkItem from "@/pages/bookmarks/components/BookmarkItem.vue";
import App from "@/shared/layouts/App.vue";
import { Bookmark } from "@/models/Bookmark";
import { BookmarkGroup } from "@/stores/bookmarks";

const props = defineProps<{
    bookmarks: Bookmark[];
    create_url: string;
}>();

const bookmarkStore = useBookmarkStore();

bookmarkStore.bookmarks = props.bookmarks.reduce(
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
    {} as Record<string, BookmarkGroup>,
);
</script>

<script lang="ts">
export default {
    Layout: App,
};
</script>
