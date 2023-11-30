<template>
    <div class="h-8 w-8 mr-2 drag-handle">
        <img
            v-if="hasIcon"
            class="object-contain m-auto w-8 h-8 overflow-hidden"
            :src="bookmarkUrl"
            :alt="`Favicon for ${bookmark.url}`"
            @error="hasIcon = false"
        />
        <IconWorld v-else />
    </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { Bookmark } from "@/types/bookmarks";
import IconWorld from "@/components/icons/IconWorld.vue";
import { extractDomain } from "@/helpers/urlExtractor";

const { bookmark } = defineProps<{ bookmark: Bookmark }>();
const hasIcon = ref(true);
const bookmarkUrl = `/storage/favicons/${extractDomain(bookmark.url)}.webp`;
</script>
