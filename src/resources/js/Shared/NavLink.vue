<script setup>
defineProps({
    active: Boolean,
});
</script>

<template>
    <Link
        class="text-blue-600 hover:underline"
        :class="{ 'font-bold underline': active }"
    >
        <slot />
    </Link>
</template>
