<template>
    <div class="py-2">
        <label class="text-md" v-if="label" :for="label">{{ label }}</label>
        <input
            class="rounded-sm w-full p-1 text-slate-900 focus:outline-0"
            :id="label"
            :value="modelValue"
            v-bind="$attrs"
            @input="$emit('update:modelValue', $event.target.value)"
        />
    </div>
</template>

<script setup lang="ts">
withDefaults(
    defineProps<{ label?: string; modelValue: string; prefix?: string }>(),
    {
        modelValue: "",
    },
);
defineEmits<{
    "update:modelValue": [newValue: string];
}>();
</script>
