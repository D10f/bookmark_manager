<template>
    <div class="absolute top-1/4 left-1/3 w-24 h-24 rounded-full animate-[spin_200s_linear_infinite]"
        :class="`bg-${color}-500`" />
</template>

<script setup lang="ts">
withDefaults(
    defineProps<{
        color: string;
        width: number;
        height: number;
    }>(),
    {
        color: "pink",
        width: 24,
        height: 24,
    },
);
</script>
