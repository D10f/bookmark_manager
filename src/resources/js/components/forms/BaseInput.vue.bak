<template>
    <div class="py-2">
        <label class="text-md" v-if="label" :for="label">{{ label }}</label>
        <input class="rounded-sm w-full p-1 text-slate-900 focus:outline-0" :id="label" :value="modelValue" v-bind="$attrs"
            @input="$emit('update:modelValue', $event.target.value)" />
        <span v-if="error" class="text-yellow-400 text-sm inline-block">
            <IconAlert class="inline fill-yellow-400 w-4 h-4" /> {{ error }}
        </span>
    </div>
</template>

<script setup lang="ts">
import IconAlert from "@/components/icons/IconAlert.vue";
defineProps<{ label?: string; error?: string; modelValue: string }>();
defineEmits<{
    "update:modelValue": [newValue: string];
}>();
</script>
