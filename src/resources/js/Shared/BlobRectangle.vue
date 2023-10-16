<template>
    <div
        class="absolute top-1/4 left-1/3 rounded-full animate-[spin_200s_linear_infinite]"
        :class="colorMap[color]"
    />
</template>

<script setup lang="ts">
type TailwindSupportedColors =
    | "blue"
    | "cyan"
    | "green"
    | "orange"
    | "pink"
    | "teal"
    | "stone"
    | "yellow";

withDefaults(
    defineProps<{
        color: TailwindSupportedColors;
        width: number;
        height: number;
    }>(),
    {
        color: "pink",
        width: 24,
        height: 24,
    },
);

const colorMap: Record<string, string> = {
    blue: "bg-blue-500",
    cyan: "bg-cyan-500",
    green: "bg-green-500",
    orange: "bg-orange-500",
    pink: "bg-pink-500",
    teal: "bg-teal-500",
    yellow: "bg-yellow-500",
};
</script>
