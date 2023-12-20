<template>
    <li class="group/item flex justify-between items-center gap-2 rounded-md px-2 py-1 hover:bg-slate-100/10">
        <BookmarkFavicon :bookmark="bookmark" />

        <a class="inline-block text-lg w-full h-full hover:text-yellow-500" :tabIndex="isCollapsed ? -1 : 0"
            :href="bookmark.url ?? '#'" target="_blank">{{ bookmark.name }}</a>
        <Link :href="bookmark.edit_url">
        <IconPencil class="flex justify-center items-center w-10 h-8 hover:bg-slate-600 p-2 rounded-full" />
        </Link>
    </li>
</template>

<script setup lang="ts">
import IconPencil from "@/components/icons/IconPencil.vue";
import BookmarkFavicon from "@/components/BookmarkFavicon.vue";
import { inject } from "vue";

defineProps<{ bookmark: App.Models.Bookmark }>();
const isCollapsed = inject("isCollapsed");
</script>
