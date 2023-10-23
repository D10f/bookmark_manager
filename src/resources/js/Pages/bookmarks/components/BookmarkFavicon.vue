<template>
    <div class="h-8 w-8 mr-2">
        <template v-if="hasIcon">
            <img :src="bookmark.icon" class="object-contain" alt="" />
        </template>
        <IconWorld v-else />
    </div>
</template>

<script setup lang="ts">
import { Bookmark } from "@/models/Bookmark";
import IconWorld from "@/shared/components/icons/IconWorld.vue";
import { computed } from "vue";

const props = defineProps<{ bookmark: Bookmark }>();
const hasIcon = computed(() => props.bookmark.hasIcon);
</script>
