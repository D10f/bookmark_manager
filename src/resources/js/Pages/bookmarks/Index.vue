<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <ButtonLink to="/create">
            <IconPlus
                class="group-hover:fill-slate-950 fill-white w-4 h-4 mr-2"
            />
            Add New Bookmark
        </ButtonLink>
    </aside>

    <BookmarkCategory
        v-for="category in bookmarkStore.categories"
        :category="category"
        :key="category"
    >
        <BookmarkItem
            v-for="bookmark in bookmarkStore.bookmarks[category].data"
            :bookmark="bookmark"
            :key="bookmark.key"
        />
    </BookmarkCategory>
</template>

<script setup lang="ts">
import IconPlus from "@/shared/components/icons/IconPlus.vue";
import ButtonLink from "@/shared/components/ButtonLink.vue";
import BookmarkCategory from "@/Pages/bookmarks/components/BookmarkCategory.vue";
import BookmarkItem from "@/Pages/bookmarks/components/BookmarkItem.vue";
import { useBookmarkStore } from "@/stores/bookmarks";
import App from "@/shared/Layouts/App.vue";

const bookmarkStore = useBookmarkStore();
</script>

<script lang="ts">
export default {
    Layout: App,
};
</script>
