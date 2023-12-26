<template>
    <li>
        <a :href="result.url"
            class="group block w-full rounded p-2 hover:bg-orange-300 focus:bg-orange-300 focus:outline-none"
            :class="isSelected ? '!bg-orange-400' : ''">
            <span class="text-slate-400 group-hover:text-gray-100 group-focus:text-gray-100"
                :class="isSelected ? '!text-gray-100' : ''">
                {{ result.path }} /
            </span>
            <span class="text-gray-100 font-bold">
                {{ result.name }}
            </span>
        </a>
    </li>
</template>

<script setup lang="ts">
import { BookmarkSearchResult } from "@/components/SearchBox.vue";

defineProps<{ result: BookmarkSearchResult; isSelected?: boolean }>();
</script>
