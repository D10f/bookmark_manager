<template>
    <div class="h-8 w-8 mr-2">
        <IconWorld v-if="!icon" />
        <template v-else>
            <img v-if="icon.isBlob" :src="icon.buffer" class="object-contain" alt="" />
            <svg v-if="icon.isSVG" v-html="icon.buffer" />
        </template>
    </div>
</template>

<script setup lang="ts">
import { Favicon } from "@/models/Favicon";
import IconWorld from "@/shared/components/icons/IconWorld.vue";

defineProps<{ icon: Favicon | null }>();
</script>
