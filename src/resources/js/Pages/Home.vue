<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <BaseButton :as="Link" :href="create_bookmark_url">
            <template #leftIcon>
                <IconPlus class="fill-current w-4 h-4" />
            </template>
            Add New Bookmark
        </BaseButton>
    </aside>

    <div class="flex flex-col justify-start gap-2 z-50" ref="sortableCardContainer">
        <CategoryCard v-for="category in categoryStore.topLevelCategories" :category="category" :key="category.id" />
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import { Link } from "@inertiajs/vue3";
import { useSortable } from "@vueuse/integrations/useSortable";
import BaseButton from "@/components/BaseButton.vue";
import IconPlus from "@/components/icons/IconPlus.vue";
import CategoryCard from "@/components/CategoryCard.vue";
import { useCategoryStore } from "@/stores/category";

const props = defineProps<{
    categories: App.Models.Category[];
    create_bookmark_url: string;
}>();

const categoryStore = useCategoryStore();
categoryStore.categories = props.categories;

const sortableCardContainer = ref<HTMLElement | null>(null);
let sortable = useSortable(sortableCardContainer, [], {
    animation: 200,
    handle: "[data-drag-handle=cardContainerHandle]",
});
</script>

<script lang="ts">
import App from "@/layouts/App.vue";
export default {
    layout: App,
};
</script>
