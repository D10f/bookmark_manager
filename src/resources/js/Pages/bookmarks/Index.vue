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
            v-for="category in categoryStore.topLevelCategories"
            :category="category"
            :key="category.id"
        />
    </div>
</template>

<script setup lang="ts">
import { computed, ref } from "vue";
import { useCategoryStore } from "@/stores/category";
import { useSortable } from "@vueuse/integrations/useSortable";
import { Link } from "@inertiajs/vue3";
import { Bookmark } from "@/types/bookmarks";
import { Category } from "@/types/category";
import IconPlus from "@/components/icons/IconPlus.vue";
import BaseButton from "@/components/BaseButton.vue";
import BookmarkCategory from "@/Pages/bookmarks/components/BookmarkCategory.vue";
import App from "@/layouts/App.vue";

const props = defineProps<{
    bookmarks: Bookmark[];
    create_url: string;
    new_bookmark?: number;
    categories: Category[];
}>();

const categoryStore = useCategoryStore();
categoryStore.loadCategories(props.categories);

// const el = ref<HTMLElement | null>(null);

// useSortable(el, props.categories, {
//     animation: 200,
//     handle: ".drag-handle-2",
// });
</script>

<script lang="ts">
export default {
    Layout: App,
};
</script>
