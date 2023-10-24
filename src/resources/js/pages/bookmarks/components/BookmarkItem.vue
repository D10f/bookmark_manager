<template>
    <li
        class="group/item flex justify-between items-center gap-2 rounded-md py-1"
    >
        <div class="h-8 w-8 mr-2">
            <BookmarkFavicon :bookmark="bookmark" />
        </div>

        <a
            class="inline-block text-lg w-full h-full hover:text-yellow-500"
            :tabIndex="isCollapsed ? -1 : 0"
            :href="url ?? '#'"
            >{{ name }}</a
        >
        <button
            class="group/edit md:invisible md:group-hover/item:visible rounded-full hover:bg-slate-600 h-8 w-9 p-2"
            :tabIndex="isCollapsed ? -1 : 0"
            @click="$emit('showEditModal', bookmark)"
        >
            <IconPencil class="group-hover/edit:fill-yellow-500" />
        </button>
    </li>
</template>

<script setup lang="ts">
import IconPencil from "@/shared/components/icons/IconPencil.vue";
import BookmarkFavicon from "@/pages/bookmarks/components/BookmarkFavicon.vue";
import { Bookmark } from "@/models/Bookmark";
import { computed, inject } from "vue";

defineEmits<{
    showEditModal: [bookmark: Bookmark];
}>();
const props = defineProps<{ bookmark: Bookmark }>();
const isCollapsed = inject("isCollapsed");

const name = computed(() => props.bookmark.name);
const url = computed(() => props.bookmark.url);
</script>

<style>
svg {
    max-width: 100%;
    max-height: 100%;
}
</style>
