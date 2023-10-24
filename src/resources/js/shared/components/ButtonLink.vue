<template>
    <Link :href="to" class="inline-block hover:text-slate-900 focus:text-slate-900">
    <BaseButton>
        <slot />
    </BaseButton>
    </Link>
</template>

<script setup lang="ts">
import BaseButton from "@/shared/components/BaseButton.vue";

withDefaults(defineProps<{ to: string }>(), { to: "#" });
</script>
