<template>
    <component :is="as" :class="buttonClass" :disabled="disabled">
        <IconCircleSpinner v-if="loading" />

        <span class="inline-flex justify-center items-center gap-2" :class="loading && 'invisible'">
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
    intent: "primary" | "rounded" | "text";
    loading: boolean;
    disabled: boolean;
}>;

const props = withDefaults(defineProps<ButtonProps>(), {
    as: "button",
    intent: "primary",
    loading: false,
    disabled: false,
});

const buttonClass = computed(() => {
    return cva(
        "inline-flex justify-center items-center text-sm font-semibold rounded min-h-[32px]",
        {
            variants: {
                intent: {
                    primary: "text-slate-900 border-b-2 px-3 py-3",
                    text: "text-gray-100 px-3 py-3",
                    rounded: "hover:bg-slate-600 rounded-full",
                },
                disabled: {
                    true: "cursor-not-allowed",
                },
            },
            compoundVariants: [
                {
                    intent: "primary",
                    disabled: false,
                    class: "bg-orange-400 border-b-orange-900 hover:bg-orange-300 focus:bg-orange-300 active:bg-orange-500 active:translate-y-[1px]",
                },
                {
                    intent: "primary",
                    disabled: true,
                    class: "text-slate-900 bg-gray-500 border-b-2 border-b-gray-600",
                },
            ],
        },
    )({
        intent: props.intent,
        disabled: props.disabled,
    });
    // return cva(
    //     "inline-flex justify-center items-center text-sm text-slate-900 font-semibold rounded min-h-[32px] px-3 py-3 border-b-2 border-b-orange-900 active:translate-y-[1px]",
    //     {
    //         variants: {
    //             intent: {
    //                 primary:
    //                     "rounded-md text-orange-900 bg-orange-400 hover:bg-orange-300 focus:bg-orange-300 active:bg-orange-500",
    //                 secondary: "bg-black/5 hover:bg-black/10 text-gray-700",
    //                 danger: "bg-red-500 text-white hover:bg-red-400",
    //                 text: "border-none shadow-none text-gray-100 hover:bg-gray-200/10 focus:bg-gray-200/10",
    //             },
    //             disabled: {
    //                 true: "bg-gray-400 !border-b-slate-400",
    //             },
    //         },
    //     },
    // )({
    //     intent: props.intent,
    //     disabled: props.disabled,
    // });
});
</script>
