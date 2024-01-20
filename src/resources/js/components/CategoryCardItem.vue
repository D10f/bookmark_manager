<template>
    <li class="group/item flex justify-between items-center gap-2 rounded-md px-2 py-1 hover:bg-slate-100/10">
        <!-- <BookmarkFavicon v-if="isBookmark" :bookmark="item" /> -->
        <!-- <div v-else class="h-8 w-8 mr-2 drag-handle" :class="{ 'pointer-events-none': draggingOver }"> -->
        <!--     <img src="/folder.png" /> -->
        <!-- </div> -->
        <CategoryCardItemIcon data-drag-handle="drag-handle" :bookmark="isBookmark ? item : null" />

        <!-- <a v-show="isBookmark" class="inline-block text-lg w-full h-full hover:text-yellow-500" :tabIndex="isCollapsed ? -1 : 0" -->
        <!--     :href="(item as App.Models.Bookmark).url ?? '#'" target="_blank">{{ (item as App.Models.Bookmark).name }}</a> -->
        <BaseButton :as="isBookmark ? 'a' : 'button'" :href="bookmarkHref" intent="text"
            class="w-full h-full hover:text-yellow-500" :target="isBookmark ? '_blank' : undefined"
            :tabIndex="isCollapsed ? -1 : 0">
            {{ itemText }}
        </BaseButton>

        <BaseButton v-show="isBookmark" as="Link" :href="(item as App.Models.Bookmark).edit_url" intent="rounded">
            <Tooltip tooltip="Edit bookmark" :showTooltip="false">
                <IconPencil class="w-8 h-8 p-2" />
            </Tooltip>
        </BaseButton>
        <!-- <Link :href="bookmark.edit_url"> -->
        <!-- <IconPencil class="flex justify-center items-center w-10 h-8 hover:bg-slate-600 p-2 rounded-full" /> -->
        <!-- </Link> -->
    </li>
</template>

<script setup lang="ts">
import { ref, inject, computed } from "vue";
import BaseButton from "@/components/BaseButton.vue";
import Tooltip from "@/components/Tooltip.vue";
import IconPencil from "@/components/icons/IconPencil.vue";

const props = defineProps<{
    item: App.Models.Category | App.Models.Bookmark;
}>();

const isBookmark = ref(props.item.hasOwnProperty("url"));
const isCollapsed = inject("isCollapsed");

const itemText = computed(() =>
    isBookmark
        ? (props.item as App.Models.Bookmark).name
        : (props.item as App.Models.Category).title,
);

const bookmarkHref = computed(() =>
    isBookmark ? (props.item as App.Models.Bookmark).url : "#",
);
</script>
