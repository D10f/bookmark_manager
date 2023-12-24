<template>
    <label v-if="label" :for="label">{{ label }}</label>
    <input type="text" v-bind="{ ...$attrs, onInput }" ref="inputRef"
        class="rounded-sm w-full p-1 text-slate-900 focus:outline-0" :id="label" :value="modelValue"
        :aria-describedby="error ? `${label}-error` : null" :aria-invalid="Boolean(error)" />
    <BaseMessage v-if="error" :id="`${label}-error`">{{ error }}</BaseMessage>
</template>

<script setup lang="ts">
import BaseMessage from "@/components/BaseMessage.vue";
import { ref, nextTick, onMounted } from "vue";

type BaseInputProps = {
    modelValue: string;
    label?: string;
    error?: string;
    autofocus?: boolean;
};

const props = withDefaults(defineProps<BaseInputProps>(), { modelValue: "" });

defineExpose({
    focus() {
        nextTick(focus);
    },
});

const emit = defineEmits<{
    (e: "update:modelValue", value: string): void;
}>();

const inputRef = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (inputRef.value && props.autofocus) {
        nextTick(focus);
    }
});

function onInput(e: Event) {
    const target = e.target as HTMLInputElement;
    emit("update:modelValue", target.value);
}

function focus() {
    inputRef?.value?.focus();
}
</script>
