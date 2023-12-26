<template>
    <li>
        <a :href="result.url" target="_blank" ref="anchorRef"
            class="group block w-full rounded p-2 hover:bg-orange-300 focus:bg-orange-300 focus:outline-none"
            :class="isSelected ? '!bg-orange-400' : ''" @focus="$emit('focus')">
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
import { onKeyDown } from "@vueuse/core";
import { ref } from "vue";

const props = defineProps<{
    result: BookmarkSearchResult;
    isSelected?: boolean;
}>();
defineEmits<{ focus: [void] }>();

const anchorRef = ref<HTMLAnchorElement | null>(null);

onKeyDown("Enter", () => {
    if (!props.isSelected || !anchorRef.value) return;
    anchorRef.value.click();
});
</script>
