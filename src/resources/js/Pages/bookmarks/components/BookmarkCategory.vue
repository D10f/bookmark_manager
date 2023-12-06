<template>
    <CardContainer collapsable :title="activeCategory.title">
        <template #breadcrumb v-if="activeCategory.parent_id">
            <CategoryCardTitle
                :category="activeCategory"
                @activateCategory="updateCategory"
            />
        </template>

        <template #actions>
            <Link href="#">
                <Tooltip tooltip="Bookmark Settings" :showTooltip="false">
                    <IconCog
                        class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
                    />
                </Tooltip>
            </Link>
        </template>

        <ul
            class="flex flex-col gap-2 transition-all"
            ref="categoryItemContainer"
        >
            <CategoryItem
                v-for="category in categoryStore.getSubcategories(
                    activeCategory,
                )"
                :category="category"
                :key="category.id"
                @activateCategory="updateCategory"
            />
            <!-- <BookmarkItem v-for="bookmark in bookmarks" :bookmark="bookmark" :key="bookmark.id" /> -->
        </ul>
    </CardContainer>
</template>

<script setup lang="ts">
import { computed, ref } from "vue";
import { useCategoryStore } from "@/stores/category";
import { Bookmark } from "@/types/bookmarks";
import Tooltip from "@/components/Tooltip.vue";
import IconCog from "@/components/icons/IconCog.vue";
import CardContainer from "@/components/CardContainer.vue";
import BookmarkItem from "@/Pages/bookmarks/components/BookmarkItem.vue";
import { useSortable } from "@vueuse/integrations/useSortable";
import { Category } from "@/types/category";
import CategoryItem from "@/Pages/categories/components/CategoryItem.vue";
import CategoryCardTitle from "@/Pages/categories/components/CategoryCardTitle.vue";

const props = defineProps<{ category: Category }>();

const categoryStore = useCategoryStore();
const activeCategory = ref(props.category);
const updateCategory = (c: Category) => (activeCategory.value = c);

// const categoryItemContainer = ref<HTMLElement | null>(null);
// useSortable(categoryItemContainer, props.bookmarks, {
//     handle: ".drag-handle",
//     animation: 200,
// });
</script>
