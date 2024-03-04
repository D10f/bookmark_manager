<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <BaseButton :as="Link" :href="create_bookmark_url">
            <template #leftIcon>
                <IconPlus class="fill-current w-4 h-4" />
            </template>
            Add New Bookmark
        </BaseButton>
    </aside>

    <div class="flex flex-col justify-start gap-2 z-50 md:grid md:grid-cols-[repeat(auto-fit,minmax(300px,1fr))] lg:grid-cols-[repeat(auto-fit,minmax(300px,1fr))]"
        ref="sortableCardContainer">
        <CategoryCard v-for="category in test" :category="category" :key="category.id" @update="updateCard" />
    </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { useSortable } from "@vueuse/integrations/useSortable";
import BaseButton from "@/components/BaseButton.vue";
import IconPlus from "@/components/icons/IconPlus.vue";
import CategoryCard from "@/components/CategoryCard.vue";
import { useCategoryStore } from "@/stores/category";
import { useDragStore } from "@/stores/drag";

const props = defineProps<{
    categories: App.Models.Category[];
    create_bookmark_url: string;
}>();

const dragStore = useDragStore();
const categoryStore = useCategoryStore();
categoryStore.categories = props.categories;

const test = ref(categoryStore.topLevelCategories);

function updateCard(newCategory: App.Models.Category, oldCategoryId: number) {
    const oldCategory = props.categories.find((c) => c.id === oldCategoryId)!;
    test.value = test.value.map((c) =>
        c.id === oldCategory.id ? newCategory : c,
    );
}

const sortableCardContainer = ref<HTMLElement | null>(null);

useSortable(sortableCardContainer, test, {
    animation: 200,
    handle: "[data-drag-handle=cardContainerHandle]",
    swapThreshold: 0.1,
    onChange({ newIndex }: SortableEvent) {
        if (newIndex === undefined || !dragStore.item) return;

        const prev = test.value[newIndex - 1]
            ? test.value[newIndex - 1].order.toString()
            : "";

        const next = test.value[newIndex + 1]
            ? test.value[newIndex + 1].order.toString()
            : "";

        const order = midString(prev, next);
        dragStore.item.order = order;

        fetch(`/api/categories/update/${dragStore.item.id}`, {
            method: "PUT",
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-XSRF-TOKEN": getCookie("XSRF-TOKEN"),
            },
            body: JSON.stringify({
                order,
            }),
        });
    },
});
</script>

<script lang="ts">
import App from "@/layouts/App.vue";
import { SortableEvent } from "sortablejs";
import { midString } from "@/helpers/lexicographic";
import { getCookie } from "@/helpers/api";
export default {
    layout: App,
};
</script>
