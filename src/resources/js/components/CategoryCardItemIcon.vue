<template>
    <div class="h-8 w-8 mr-2" data-drag-handle="drag-handle">
        <!-- <BookmarkFavicon v-if="bookmark" :bookmark="bookmark" /> -->
        <!-- <img src="/folder.png" /> -->

        <img class="object-contain m-auto overflow-hidden" :src="iconUrl" :alt="iconAlt" @error="" />
    </div>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { extractDomain } from "@/helpers/urlExtractor";

const props = defineProps<{
    bookmark: App.Models.Bookmark | null;
}>();

const iconUrl = computed(() =>
    props.bookmark
        ? `/storage/favicons/${extractDomain(props.bookmark.url)}.webp`
        : "/folder.png",
);

const iconAlt = computed(() =>
    props.bookmark
        ? `Favicon for ${props.bookmark.name}`
        : "Icon of a blue folder",
);
</script>
