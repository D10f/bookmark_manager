<template>
    <CardContainer collapsable sortable :title="category.title">
        <template #title>
            <CategoryCardTitle :category="category" @activateCategory="updateCategory" />
        </template>

        <template #actions>
            <BaseButton as="Link" :href="category.edit_url" intent="rounded">
                <Tooltip tooltip="Settings" :showTooltip="false">
                    <IconCog class="w-8 h-8 p-2" />
                </Tooltip>
            </BaseButton>
        </template>

        <!-- <ul class="flex flex-col gap-2 transition-all" :key="categoryStore.categoryFQDN(root.active).join('')" -->
        <!--     <CategoryItem v-for="category in root.categories" :category="category" :key="category.id" -->
        <!--         @activateCategory="updateCategory" @dropItem="handleDrop" @dragStart="" /> -->
        <!--     <BookmarkItem v-for="bookmark in root.bookmarks" :bookmark="bookmark" :key="bookmark.id" -->
        <!--         @dragStart="dragged = $event" /> -->
        <!-- </ul> -->
        <ul class="flex flex-col gap-2 transition-all" ref="sortableContainer">
            <CategoryItem v-for="category in subcategories" :category="category" :key="category.id"
                @activateCategory="updateCategory" @dropItem="" @dragStart="" />
            <BookmarkItem v-for="bookmark in bookmarks" :bookmark="bookmark" :key="bookmark.id" @dragStart="" />
        </ul>
    </CardContainer>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useSortable } from "@vueuse/integrations/useSortable";
import { SortableEvent } from "sortablejs";
import { midString, seqString } from "@/helpers/lexicographic";
import { useCategoryStore } from "@/stores/category";
import CardContainer from "@/components/CardContainer.vue";
import CategoryCardTitle from "@/components/CategoryCardTitle.vue";
import CategoryItem from "@/components/CategoryItem.vue";
import BookmarkItem from "@/components/BookmarkItem.vue";
import BaseButton from "@/components/BaseButton.vue";
import Tooltip from "@/components/Tooltip.vue";
import IconCog from "@/components/icons/IconCog.vue";

const props = defineProps<{ category: App.Models.Category }>();
const emits = defineEmits<{
    update: [
        newCategory: App.Models.Category,
        oldCategory: App.Models.Category,
    ];
}>();

const updateCategory = (newCategory: App.Models.Category) => {
    emits("update", newCategory, props.category);
};

const categoryStore = useCategoryStore();
const { subcategories, bookmarks } = categoryStore.getCategoryChildren(
    props.category,
);

const sortableContainer = ref<HTMLElement | null>(null);
const sortedItems = ref(
    [...subcategories, ...bookmarks].sort((a, b) =>
        a.order < b.order ? 1 : -1,
    ),
);

useSortable(sortableContainer, sortedItems, {
    handle: "[data-drag-handle=bookmarkItemHandle]",
    group: "category-items",
    animation: 200,
    swapThreshold: 0.1,
    onStart() {
        sortedItems.value.forEach((i) => console.log(i.order));
    },
    onEnd({ oldIndex, newIndex }: SortableEvent) {
        if (newIndex === undefined || oldIndex === undefined) return;

        // TODO: check if moved onto another category

        const prev = sortedItems.value[newIndex - 1]?.order.toString() || "";
        const next = sortedItems.value[newIndex + 1]?.order.toString() || "";
        console.log(midString(prev, next));
        sortedItems.value.forEach((i) => console.log(i.order));
    },
});
</script>
