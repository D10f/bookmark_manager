<template>
    <div class="relative group inline" ref="tooltipRef">
        <slot />
        <span
            v-text="tooltip"
            v-show="showTooltip"
            ref="contentRef"
            class="absolute z-50 bg-slate-100 text-slate-900 text-sm w-max max-w-4xl rounded-md p-1 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-100 delay-500"
            v-bind="$attrs"
        />
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from "vue";

withDefaults(
    defineProps<{
        tooltip: string;
        position?: "left" | "right" | "top" | "bottom";
        showTooltip?: boolean;
    }>(),
    {
        position: "top",
        showTooltip: true,
    },
);

const tooltipRef = ref<HTMLElement | null>(null);
const contentRef = ref<HTMLSpanElement | null>(null);

onMounted(() => {
    const span = contentRef.value as HTMLSpanElement;
    const rect = span.getBoundingClientRect();

    if (rect.y <= 0) {
        span.style.top = rect.y <= 0 ? `${rect.height + 4}px` : `${rect.y}px`;
    }
    if (rect.x + rect.width >= window.innerWidth) {
        span.style.left = `-${rect.width + 4}px`;
    }
    if (rect.y + rect.height >= window.innerHeight) {
        span.style.bottom = `-${rect.height + 4}px`;
    }
    if (rect.x <= 0) {
        span.style.left = `${rect.width + 4}px`;
    }
});
</script>
