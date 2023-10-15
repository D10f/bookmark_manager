<template>
    <section
        class="z-10 bg-slate-900 bg-opacity-80 border-b border-b-slate-700 rounded-md shadow-y shadow-sm shadow-slate-900"
    >
        <header
            class="group flex justify-between items-center bg-slate-950 font-bold text-md rounded-t-md p-3"
        >
            <h3>{{ title }}</h3>

            <div class="opacity-25 group-hover:opacity-100 flex gap-3 text-xl">
                <button
                    class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
                >
                    <IconCog />
                </button>
                <button
                    class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
                >
                    <IconChevron />
                </button>
            </div>
        </header>

        <div class="p-4">
            <ul class="flex flex-col">
                <template v-for="bookmark in bookmarks" :key="bookmark.key">
                    <BookmarkItem :name="bookmark.name" :url="bookmark.url" />
                </template>
            </ul>
        </div>
    </section>
</template>

<script setup lang="ts">
import IconChevron from "@/Shared/IconChevron.vue";
import IconCog from "@/Shared/IconCog.vue";
import BookmarkItem from "@/Shared/BookmarkItem.vue";
import { Bookmark } from "@/types";

defineProps<{ title: string; bookmarks: Bookmark[] }>();
</script>
