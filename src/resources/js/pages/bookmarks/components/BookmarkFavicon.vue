<template>
    <div class="h-8 w-8 mr-2">
        <template v-if="Boolean(bookmark.iconUrl)">
            <img :src="bookmark.iconUrl" class="object-contain" alt="" />
        </template>
        <IconWorld v-else />
    </div>
</template>

<script setup lang="ts">
import { Bookmark } from "@/models/Bookmark";
import IconWorld from "@/shared/components/icons/IconWorld.vue";

defineProps<{ bookmark: Bookmark }>();
</script>
