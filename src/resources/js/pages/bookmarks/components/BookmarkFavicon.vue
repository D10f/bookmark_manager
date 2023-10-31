<template>
    <div class="h-8 w-8 mr-2">
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
import { Bookmark } from "@/models/Bookmark";
import IconWorld from "@/shared/components/icons/IconWorld.vue";
import { extractDomain } from "@/shared/helpers/urlExtractor";
import { ref } from "vue";

const props = defineProps<{ bookmark: Bookmark }>();

const hasIcon = ref(true);
const bookmarkUrl = `/storage/favicons/${extractDomain(
    props.bookmark.url,
)}.webp`;
</script>
