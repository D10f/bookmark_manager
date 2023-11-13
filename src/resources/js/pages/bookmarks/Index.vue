<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <ButtonLink :to="create_url">
            <IconPlus
                class="group-hover:fill-slate-950 fill-white w-4 h-4 mr-2"
            />
            Add New Bookmark
        </ButtonLink>
    </aside>

    <div class="flex flex-col justify-start gap-2 z-50" ref="el">
        <BookmarkCategory
            v-for="category in bookmarkStore.categories"
            :category="category"
            :key="category"
            :bookmarks="bookmarkStore.bookmarks[category].data"
        />
        <!-- <BookmarkItem -->
        <!--     v-for="bookmark in bookmarkStore.bookmarks[category].data" -->
        <!--     :bookmark="bookmark" -->
        <!--     :key="bookmark.id" -->
        <!-- /> -->
        <!-- </BookmarkCategory> -->
    </div>
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
import { useSortable } from "@vueuse/integrations/useSortable";
import { onMounted, ref } from "vue";

const props = defineProps<{
    bookmarks: Bookmark[];
    create_url: string;
    new_bookmark?: string;
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

const el = ref<HTMLElement | null>(null);
useSortable(el, bookmarkStore.categories, {
    animation: 200,
});
</script>

<script lang="ts">
export default {
    Layout: App,
};
</script>
