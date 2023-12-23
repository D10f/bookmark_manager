<template>
    <CardContainer collapsable sortable :title="activeCategory.title">
        <template #title>
            <CategoryCardTitle :category="activeCategory" @activateCategory="updateCategory" />
        </template>

        <template #actions>
            <BaseButton intent="rounded">
                <Tooltip tooltip="Settings" :showTooltip="false">
                    <IconCog class="w-8 h-8 p-2" />
                </Tooltip>
            </BaseButton>
            <!-- <Link :href="activeCategory.edit_url!"> -->
            <!-- <Tooltip tooltip="Settings" :showTooltip="false"> -->
            <!--     <IconCog class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full" /> -->
            <!-- </Tooltip> -->
            <!-- </Link> -->
        </template>

        <ul class="flex flex-col gap-2 transition-all" :key="categoryStore.categoryFQDN(activeCategory).join('')">
            <CategoryItem v-for="category in subCategories" :category="category" :key="category.id"
                @activateCategory="updateCategory" />
            <div ref="sortableContainer">
                <BookmarkItem v-for="bookmark in activeCategory.bookmarks" :bookmark="bookmark" :key="bookmark.id" />
            </div>
        </ul>
    </CardContainer>
</template>

<script setup lang="ts">
import { computed, ref, watch } from "vue";
import { useSortable } from "@vueuse/integrations/useSortable";
import { useCategoryStore } from "@/stores/category";
import { Link } from "@inertiajs/vue3";
import CardContainer from "@/components/CardContainer.vue";
import CategoryCardTitle from "@/components/CategoryCardTitle.vue";
import CategoryItem from "@/components/CategoryItem.vue";
import BookmarkItem from "@/components/BookmarkItem.vue";
import BaseButton from "@/components/BaseButton.vue";
import Tooltip from "@/components/Tooltip.vue";
import IconCog from "@/components/icons/IconCog.vue";

const props = defineProps<{ category: App.Models.Category }>();
const categoryStore = useCategoryStore();

const activeCategory = ref(props.category);
const updateCategory = (category: App.Models.Category) => {
    activeCategory.value = category;
};

const subCategories = computed(() =>
    categoryStore.categories.filter(
        (c) => c.parent_id === activeCategory.value.id,
    ),
);

const sortableContainer = ref<HTMLElement | null>(null);
const sortees = computed(() => activeCategory.value.bookmarks);
let sortable = useSortable(sortableContainer, sortees, {
    handle: "[data-drag-handle=bookmarkItemHandle]",
    animation: 200,
});

watch(
    activeCategory,
    () => {
        sortable.stop();
        sortable = useSortable(
            sortableContainer,
            activeCategory.value.bookmarks,
            { animation: 200 },
        );
    },
    { deep: false, flush: "post" },
);
</script>
