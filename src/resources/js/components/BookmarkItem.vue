<template>
    <li class="group/item flex justify-between items-center gap-2 rounded-md px-2 py-1 hover:bg-slate-100/10"
        @dragstart="dragStore.item = bookmark">
        <BookmarkFavicon :bookmark="bookmark" />

        <a class="inline-block text-lg overflow-hidden whitespace-nowrap w-full h-full hover:text-yellow-500"
            :tabindex="isCollapsed ? -1 : 0" :href="bookmark.url ?? '#'" target="_blank" :title="bookmark.name">{{
                bookmark.name }}</a>

        <BaseButton as="Link" :href="bookmark.edit_url" intent="rounded" :tabindex="isCollapsed ? -1 : 0"
            class="visible" :class="!isTouchDevice &&
                'invisible group-hover/item:visible group-focus-within/item:visible'
                ">
            <!-- class="opacity-100 sm:opacity-25 group-hover/item:opacity-100 group-focus-within/item:opacity-100"> -->
            <Tooltip tooltip=" Edit bookmark" :showTooltip="false">
                <IconPencil class="w-8 h-8 p-2" />
            </Tooltip>
        </BaseButton>
        <!-- <Link :href="bookmark.edit_url"> -->
        <!-- <IconPencil class="flex justify-center items-center w-10 h-8 hover:bg-slate-600 p-2 rounded-full" /> -->
        <!-- </Link> -->
    </li>
</template>

<script setup lang="ts">
import { computed, inject } from "vue";
import { useDragStore } from "@/stores/drag";
import { usePointer } from "@vueuse/core";
import IconPencil from "@/components/icons/IconPencil.vue";
import BookmarkFavicon from "@/components/BookmarkFavicon.vue";
import BaseButton from "@/components/BaseButton.vue";
import Tooltip from "@/components/Tooltip.vue";

defineProps<{ bookmark: App.Models.Bookmark }>();
// defineEmits<{ dragStart: [bookmark: App.Models.Bookmark] }>();
const isCollapsed = inject("isCollapsed");
const dragStore = useDragStore();

const pointer = usePointer();
const isTouchDevice = computed(() => pointer.pointerType.value === "touch");
</script>
