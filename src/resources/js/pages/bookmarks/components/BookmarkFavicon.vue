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
// import { useTimeoutPoll } from "@vueuse/core";
import { Bookmark } from "@/models/Bookmark";
import IconWorld from "@/shared/components/icons/IconWorld.vue";
import { extractDomain } from "@/shared/helpers/urlExtractor";
// import { usePage } from "@inertiajs/vue3";

const { bookmark } = defineProps<{ bookmark: Bookmark }>();
const hasIcon = ref(true);
const bookmarkUrl = `/storage/favicons/${extractDomain(bookmark.url)}.webp`;

// function initPolling() {
//     if (usePage().props.new_bookmark !== bookmark.id) {
//         hasIcon.value = false;
//         return;
//     }

//     console.log("should run once");

//     const { pause } = useTimeoutPoll(fetchIcon, 2500, {
//         immediate: true,
//     });

//     async function fetchIcon() {
//         const res = await fetch(bookmarkUrl);
//         if (res.ok) {
//             hasIcon.value = true;
//             pause();
//         }
//     }
// }
</script>
