<template>
    <component :is="as" :class="buttonClass" :disabled="disabled">
        <IconCircleSpinner v-if="loading" />

        <span
            class="inline-flex justify-center items-center gap-2"
            :class="loading && 'invisible'"
        >
            <slot name="leftIcon" />
            <slot />
            <slot name="rightIcon" />
        </span>
    </component>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { cva } from "class-variance-authority";
import IconCircleSpinner from "@/components/icons/IconCircleSpinner.vue";

type ButtonProps = Partial<{
    as: any;
    intent: "primary" | "secondary" | "danger" | "text";
    loading: boolean;
    disabled: boolean;
}>;

const props = withDefaults(defineProps<ButtonProps>(), {
    as: "button",
    intent: "primary",
});

const buttonClass = computed(() => {
    return cva(
        "inline-flex justify-center items-center text-sm text-slate-900 font-semibold rounded min-h-[32px] px-3 py-3 border-b border-b-orange-900 shadow-y shadow-sm shadow-orange-900 active:translate-y-[1px]",
        {
            variants: {
                intent: {
                    primary:
                        "rounded-md text-orange-900 bg-orange-400 hover:bg-orange-500 active:bg-orange-600 focus:bg-orange-600",
                    secondary: "bg-black/5 hover:bg-black/10 text-gray-700",
                    danger: "bg-red-500 text-white hover:bg-red-400",
                    text: "",
                },
                disabled: {
                    true: "!bg-gray-400 text-gray-500 opacity-75 cursor-not-allowed",
                },
            },
        },
    )({
        intent: props.intent,
        disabled: props.disabled,
    });
});
</script>
