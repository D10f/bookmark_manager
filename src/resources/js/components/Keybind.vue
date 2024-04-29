<template>
    <div class="flex justify-between items-center py-1">
        <slot />
        <span class="pointer-events-none">
            <template v-for="(key, idx) in keys">
                <kbd
                    class="text-sm text-center uppercase min-w-[32px] p-1 inline-block font-semibold rounded border-b-2 bg-slate-600 border-b-gray-700">
                    {{ key }}
                </kbd>
                {{ idx + 1 < keys.length ? " + " : "" }} </template>
        </span>
    </div>
</template>

<script setup lang="ts">
const props = defineProps<{
    keys: string[];
}>();
</script>
