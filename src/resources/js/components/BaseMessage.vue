<template>
    <p aria-live="assertive" :id="id" :class="[
        'text-sm flex items-center',
        severity === 'info' && 'text-blue-400',
        severity === 'warn' && 'text-yellow-400',
        severity === 'error' && 'text-red-400',
    ]">
        <IconInfo v-show="severity === 'info'" class="fill-blue-400 inline w-4 h-4 mr-1" />
        <IconAlert v-show="severity === 'warn'" class="fill-yellow-400 inline w-4 h-4 mr-1" />
        <IconError v-show="severity === 'error'" class="fill-red-400 inline w-4 h-4 mr-1" />
        <slot />
    </p>
</template>

<script setup lang="ts">
import IconInfo from "@/components/icons/IconInfo.vue";
import IconAlert from "@/components/icons/IconAlert.vue";
import IconError from "@/components/icons/IconError.vue";

withDefaults(
    defineProps<{
        id: string;
        severity: "info" | "warn" | "error";
    }>(),
    { severity: "warn" },
);
</script>
