<template>
    <div
        class="bg-slate-900 bg-opacity-80 border-b border-b-slate-700 rounded-md shadow-y shadow-sm shadow-slate-900 z-10"
    >
        <header
            class="md:group flex justify-between items-center bg-slate-950 font-bold text-md rounded-t-md p-3"
        >
            <h3>{{ title }}</h3>
            <div
                class="md:opacity-25 md:group-hover:opacity-100 flex gap-3 text-xl"
            >
                <slot name="actions" />
            </div>
        </header>

        <slot />
    </div>
</template>

<script setup lang="ts">
defineProps<{ title: string }>();
</script>
