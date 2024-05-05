<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <BaseButton as="Link" :href="page.props.home_url">
            <IconChevron class="rotate-90 fill-current w-4 h-4" />
            Back
        </BaseButton>
    </aside>
    <slot />
</template>

<script setup lang="ts">
import BaseButton from "@/components/BaseButton.vue";
import IconChevron from "@/components/icons/IconChevron.vue";
import { usePage } from "@inertiajs/vue3";
const page = usePage();
</script>
