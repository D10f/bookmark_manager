<template>
    <li class="group/item flex justify-between items-center rounded-md p-1">
        <a
            class="inline-block w-full h-full hover:text-yellow-500"
            :href="bookmark.url ?? '#'"
            >{{ bookmark.name }}</a
        >
        <button
            class="group/edit md:invisible md:group-hover/item:visible rounded-full hover:bg-slate-600 h-8 w-8 p-2"
        >
            <IconPencil class="group-hover/edit:fill-yellow-500" />
        </button>
    </li>
</template>

<script setup lang="ts">
import IconPencil from "@/Shared/IconPencil.vue";
import { Bookmark } from "@/types";

defineProps<{ bookmark: Bookmark }>();
</script>
