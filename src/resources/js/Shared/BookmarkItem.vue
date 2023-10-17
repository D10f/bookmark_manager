<template>
    <li
        class="group/item flex justify-between items-center gap-2 rounded-md p-1"
    >
        <IconWorld class="h-12 w-12 mr-2" />

        <a
            class="inline-block text-lg w-full h-full hover:text-yellow-500"
            :tabIndex="isCollapsed ? -1 : 0"
            :href="bookmark.url ?? '#'"
            >{{ bookmark.name }}</a
        >
        <button
            class="group/edit md:invisible md:group-hover/item:visible rounded-full hover:bg-slate-600 h-8 w-9 p-2"
            :tabIndex="isCollapsed ? -1 : 0"
        >
            <IconPencil class="group-hover/edit:fill-yellow-500" />
        </button>
    </li>
</template>

<script setup lang="ts">
import IconPencil from "@/Shared/IconPencil.vue";
import IconWorld from "@/Shared/IconWorld.vue";
import { Bookmark } from "@/types";
import { inject } from "vue";

defineProps<{ bookmark: Bookmark }>();
const isCollapsed = inject("isCollapsed");
</script>
