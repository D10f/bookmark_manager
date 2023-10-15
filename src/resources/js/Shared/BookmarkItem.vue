<template>
    <li class="group flex justify-between items-center rounded-md p-1">
        <a
            class="inline-block w-full h-full hover:text-yellow-500"
            :href="url"
            >{{ name }}</a
        >
        <button class="invisible group-hover:visible h-5 w-5">
            <IconPencil class="hover:fill-yellow-500" />
        </button>
    </li>
</template>

<script setup lang="ts">
import IconPencil from "@/Shared/IconPencil.vue";

withDefaults(defineProps<{ name: string; url: string }>(), { url: "#" });
</script>
