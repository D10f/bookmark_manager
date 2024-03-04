<template>
    <!-- 768: Tailwind's md screen breakpoint -->
    <CardContainer :collapsable="width < 768" sortable :title="category.title">
        <template #title>
            <CategoryCardTitle :category="category" @activateCategory="upCategoryLevel" />
        </template>

        <template #actions>
            <BaseButton as="Link" :href="category.edit_url" intent="rounded">
                <Tooltip tooltip="Settings" :showTooltip="false">
                    <IconCog class="w-8 h-8 p-2" />
                </Tooltip>
            </BaseButton>
        </template>

        <ul class="flex flex-col gap-2 transition-all" ref="sortableContainer">
            <template v-for="item in sortedItems" :key="item.id">
                <CategoryItem v-if="item.hasOwnProperty('parent_id')" :category="item as App.Models.Category"
                    @activateCategory="downCategoryLevel" @dropItem="handleDrop" />
                <BookmarkItem v-if="item.hasOwnProperty('category_id')" :bookmark="item as App.Models.Bookmark" />
            </template>
        </ul>
    </CardContainer>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useWindowSize } from "@vueuse/core";
import { useSortable } from "@vueuse/integrations/useSortable";
import { SortableEvent } from "sortablejs";
import { useDragStore } from "@/stores/drag";
import CardContainer from "@/components/CardContainer.vue";
import CategoryCardTitle from "@/components/CategoryCardTitle.vue";
import CategoryItem from "@/components/CategoryItem.vue";
import BookmarkItem from "@/components/BookmarkItem.vue";
import BaseButton from "@/components/BaseButton.vue";
import Tooltip from "@/components/Tooltip.vue";
import IconCog from "@/components/icons/IconCog.vue";
import { useCategoryStore } from "@/stores/category";

const props = defineProps<{
    category: App.Models.Category;
}>();

const emits = defineEmits<{
    update: [newCategory: App.Models.Category, oldCategoryId: number];
}>();

const { width } = useWindowSize();

const categoryStore = useCategoryStore();
const dragStore = useDragStore();

function upCategoryLevel(newCategory: App.Models.Category) {
    emits("update", newCategory, props.category.id);
}
function downCategoryLevel(newCategory: App.Models.Category) {
    emits("update", newCategory, newCategory.parent_id!);
}

const sortableContainer = ref<HTMLElement | null>(null);
const { subcategories, bookmarks } = categoryStore.getCategoryChildren(
    props.category,
);

const sortedItems = [...subcategories, ...bookmarks].sort((a, b) =>
    a.order < b.order ? -1 : 1,
);

useSortable(sortableContainer, sortedItems, {
    handle: "[data-drag-handle=bookmarkItemHandle]",
    group: "category-items",
    animation: 200,
    swapThreshold: 0.5,
    onChange({ newIndex }: SortableEvent) {
        if (newIndex === undefined) return;
        dragStore.categoryCardId = props.category.id;
        dragStore.categoryItems = sortedItems;
        dragStore.categoryIndex = newIndex;
    },
    onAdd({ newIndex }: SortableEvent) {
        if (newIndex === undefined || dragStore.droppedCategory) return;

        const order = dragStore.getIndex(sortedItems, newIndex);

        if (dragStore.item!.hasOwnProperty("category_id")) {
            props.category.bookmarks.push({
                ...(dragStore.item as App.Models.Bookmark),
                order,
            });
        } else {
            const category = categoryStore.categories.find(
                (c) => c.id === (dragStore.item as App.Models.Category).id,
            )!;
            category.parent_id = props.category.id;
            category.order = order;
        }
    },
    onRemove() {
        if (dragStore.droppedCategory) return;

        if (dragStore.item!.hasOwnProperty("category_id")) {
            const category = categoryStore.categories.find(
                (c) => c.id === props.category.id,
            )!;
            category.bookmarks = category.bookmarks.filter(
                (b) => b.id !== dragStore.item!.id,
            );
        }
    },
    onEnd({ item }: SortableEvent) {
        if (dragStore.droppedCategory) {
            (item as HTMLElement).remove();
        }
        dragStore.commit();
        dragStore.reset();
    },
});

function handleDrop(category: App.Models.Category) {
    dragStore.droppedCategory = category;
    dragStore.categoryCardId = category.id;

    const { subcategories, bookmarks } =
        categoryStore.getCategoryChildren(category);

    const sortedItems = [...subcategories, ...bookmarks].sort((a, b) =>
        a.order < b.order ? -1 : 1,
    );

    dragStore.categoryItems = sortedItems;
    dragStore.categoryIndex = sortedItems.length - 1;

    if (dragStore.item!.hasOwnProperty("category_id")) {
        props.category.bookmarks.push({
            ...(dragStore.item as App.Models.Bookmark),
            order: "zzzz",
        });
        const category = categoryStore.categories.find(
            (c) => c.id === props.category.id,
        )!;
        category.bookmarks = category.bookmarks.filter(
            (b) => b.id !== dragStore.item!.id,
        );
    } else {
        const category = categoryStore.categories.find(
            (c) => c.id === (dragStore.item as App.Models.Category).id,
        )!;
        category.parent_id = props.category.id;
        category.order = "zzzz";
    }
}

// const props = defineProps<{ category: App.Models.Category }>();
// const emits = defineEmits<{
//     update: [
//         newCategory: App.Models.Category,
//         oldCategory: App.Models.Category,
//     ];
// }>();

// const updateCategory = (newCategory: App.Models.Category) => {
//     emits("update", newCategory, props.category);
// };

// const dragStore = useDragStore();

// const categoryStore = useCategoryStore();
// const { subcategories, bookmarks } = categoryStore.getCategoryChildren(
//     props.category,
// );

// const sortableContainer = ref<HTMLElement | null>(null);
// const sortedItems = ref(
//     [...subcategories, ...bookmarks].sort((a, b) =>
//         a.order < b.order ? -1 : 1,
//     ),
// );

// useSortable(sortableContainer, sortedItems, {
//     handle: "[data-drag-handle=bookmarkItemHandle]",
//     group: "category-items",
//     animation: 200,
//     swapThreshold: 0.5,
//     onChange({ newIndex }: SortableEvent) {
//         if (newIndex === undefined || !dragStore.item) return;

//         const prev = sortedItems.value[newIndex - 1]
//             ? sortedItems.value[newIndex - 1].order.toString()
//             : "";

//         const next = sortedItems.value[newIndex + 1]
//             ? sortedItems.value[newIndex + 1].order.toString()
//             : "";

//         const order = midString(prev, next);
//         dragStore.item.order = order;

//         let url: string;

//         if (dragStore.item.hasOwnProperty("category_id")) {
//             // is bookmark
//             url = `/api/bookmarks/update/${dragStore.item.id}`;
//             (dragStore.item as App.Models.Bookmark).category_id =
//                 props.category.id;
//         } else {
//             // is category
//             url = `/api/categories/update/${dragStore.item.id}`;
//             (dragStore.item as App.Models.Category).parent_id =
//                 props.category.id;
//         }

//         fetch(url, {
//             method: "PUT",
//             headers: {
//                 Accept: "application/json",
//                 "Content-Type": "application/json",
//                 "X-XSRF-TOKEN": getCookie("XSRF-TOKEN"),
//             },
//             body: JSON.stringify({
//                 parent_id: props.category.id,
//                 order,
//             }),
//         });
//     },
//     onAdd(e: SortableEvent) {
//         if (!dragStore.item) return;

//         sortedItems.value = [...sortedItems.value, dragStore.item].sort(
//             (a, b) => (a.order < b.order ? -1 : 1),
//         );

//         (e.item as HTMLElement).remove();
//     },
//     onRemove() {
//         if (!dragStore.item) return;

//         sortedItems.value = sortedItems.value.filter(
//             (i) => i.id !== dragStore!.item!.id,
//         );
//     },
//     onEnd() {
//         dragStore.reset();
//     },
// });
</script>
