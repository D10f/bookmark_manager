<template>
    <button
        class="group min-w-[60px] flex justify-around items-center border-b border-b-slate-700 rounded-md shadow-y shadow-sm shadow-slate-900 bg-slate-950 hover:bg-yellow-500 active:bg-yellow-600 p-2"
        :class="{
            'bg-gray-500 hover:bg-gray-500 active:bg-gray-500 cursor-not-allowed':
                loading,
        }" :disabled="loading">
        <slot v-if="!loading" />
        <slot v-if="loading" name="loading" />
    </button>
</template>

<script setup lang="ts">
withDefaults(defineProps<{ loading?: boolean }>(), { loading: false });
</script>
