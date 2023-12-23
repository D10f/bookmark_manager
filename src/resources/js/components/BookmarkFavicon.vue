<template>
    <div class="h-8 w-8 mr-2" data-drag-handle="bookmarkItemHandle">
        <img v-if="hasIcon" class="object-contain m-auto w-8 h-8 overflow-hidden" :src="bookmarkUrl"
            :alt="`Favicon for ${bookmark.url}`" @error="hasIcon = false" />
        <!-- <IconWorld v-else /> -->

        <!-- <img -->
        <!--     class="object-contain m-auto w-8 h-8 overflow-hidden" -->
        <!--     :alt="`Favicon for ${bookmark.url}`" -->
        <!--     @error="hasIcon = false" -->
        <!--     :src="hasIcon ? bookmarkUrl : '/bookmark-svgrepo-com.svg'" -->
        <!-- /> -->
    </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import IconWorld from "@/components/icons/IconWorld.vue";
import { extractDomain } from "@/helpers/urlExtractor";

const { bookmark } = defineProps<{ bookmark: App.Models.Bookmark }>();
const hasIcon = ref(true);
const bookmarkUrl = `/storage/favicons/${extractDomain(bookmark.url)}.webp`;
</script>
