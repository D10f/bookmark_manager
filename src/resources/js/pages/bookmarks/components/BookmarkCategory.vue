<template>
    <CardContainer collapsable :title="category">
        <template #actions>
            <Link href="#">
                <Tooltip tooltip="Bookmark Settings" :showTooltip="false">
                    <IconCog
                        class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
                    />
                </Tooltip>
            </Link>
        </template>

        <ul class="flex flex-col gap-2 transition-all" ref="el">
            <BookmarkItem
                v-for="bookmark in bookmarks"
                :bookmark="bookmark"
                :key="bookmark.id"
            />
        </ul>
    </CardContainer>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { Bookmark } from "@/models/Bookmark";
import Tooltip from "@/shared/components/Tooltip.vue";
import IconCog from "@/shared/components/icons/IconCog.vue";
import CardContainer from "@/shared/components/CardContainer.vue";
import BookmarkItem from "@/pages/bookmarks/components/BookmarkItem.vue";
import { useSortable } from "@vueuse/integrations/useSortable";

const props = defineProps<{ category: string; bookmarks: Bookmark[] }>();
defineEmits<{
    showEditModal: [bookmark: Bookmark];
}>();

const el = ref<HTMLElement | null>(null);
useSortable(el, props.bookmarks, { handle: ".drag-handle", animation: 200 });
</script>
