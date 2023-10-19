<script setup lang="ts">
import IconPlus from "@/shared/components/icons/IconPlus.vue";
import BaseButton from "@/shared/components/BaseButton.vue";
import CreateBookmarkModal from "@/Pages/bookmarks/components/CreateBookmarkModal.vue";
import BookmarkContainer from "@/Pages/bookmarks/components/BookmarkContainer.vue";
import BookmarkItem from "@/Pages/bookmarks/components/BookmarkItem.vue";
import { useBookmarkStore } from "@/stores/bookmarks";
import { ref } from "vue";
import App from "@/shared/Layouts/App.vue";

const bookmarkStore = useBookmarkStore();

let showModal = ref(false);
</script>

<script lang="ts">
export default {
    Layout: App,
};
</script>

<template>
    <aside class="mt-2 z-10">
        <BaseButton @click="showModal = true" class="ml-auto">
            <IconPlus class="group-hover:fill-slate-950 fill-white w-4 h-4 mr-2" />
            Add New Bookmark
        </BaseButton>
    </aside>

    <BookmarkContainer v-for="category in bookmarkStore.bookmarks.values()" :title="category.title" :key="category.title">
        <BookmarkItem v-for="bookmark in category.data" :bookmark="bookmark" :key="bookmark.key" />
    </BookmarkContainer>

    <CreateBookmarkModal :show="showModal" @closeModal="showModal = false" />
</template>
