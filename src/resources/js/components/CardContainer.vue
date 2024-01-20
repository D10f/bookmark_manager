<template>
    <section
        class="bg-slate-900 bg-opacity-80 border-b border-b-slate-700 rounded-md shadow-y shadow-sm shadow-slate-900 z-10">
        <header class="md:group flex justify-between items-center bg-slate-950 font-bold text-md rounded-t-md p-3">
            <h3 class="flex justify-start items-center">
                <slot name="title" />
                <span v-show="title">{{ title }}</span>
            </h3>

            <div class="md:opacity-25 md:group-hover:opacity-100 flex gap-3 text-xl">
                <slot name="actions" />

                <!-- <button v-show="sortable" class="cardContainerHandle"> -->
                <!--     <IconVertical -->
                <!--         class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full transition-transform duration-250" /> -->
                <!-- </button> -->
                <BaseButton v-show="sortable" intent="rounded" data-drag-handle="cardContainerHandle"
                    class="w-[32px] cursor-grab">
                    <!-- <Tooltip tooltip="Drag to switch order" :showTooltip="false"> -->
                    <!--     <IconVertical class="w-8 h-8 p-2" /> -->
                    <!-- </Tooltip> -->
                    &vellip;
                </BaseButton>

                <!-- <button v-show="collapsable" @click="toggleCollapse"> -->
                <!--     <Tooltip :tooltip="isCollapsed ? 'Expand' : 'Collapse'" :showTooltip="false"> -->
                <!--         <IconChevron -->
                <!--             class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full transition-transform duration-250" -->
                <!--             :class="{ 'rotate-180': !isCollapsed }" /> -->
                <!--     </Tooltip> -->
                <!-- </button> -->

                <BaseButton v-show="collapsable" intent="rounded" @click="toggleCollapse">
                    <Tooltip :tooltip="isCollapsed ? 'Expand' : 'Collapse'" :showTooltip="false">
                        <IconChevron class="w-8 h-8 p-2 transition-transform duration-250"
                            :class="{ 'rotate-180': !isCollapsed }" />
                    </Tooltip>
                </BaseButton>
            </div>
        </header>

        <div class="overflow-hidden transition-all duration-300 px-4 py-2 max-h-[50vh] will-change-auto" tabindex="-1"
            :class="{
                '!max-h-0 !duration-200 !py-0': isCollapsed,
                'overflow-scroll': !isCollapsing,
            }">
            <slot />
        </div>
    </section>
</template>

<script setup lang="ts">
import { ref, provide } from "vue";
import Tooltip from "@/components/Tooltip.vue";
import BaseButton from "@/components/BaseButton.vue";
import IconChevron from "@/components/icons/IconChevron.vue";
import IconVertical from "@/components/icons/IconVertical.vue";

withDefaults(
    defineProps<{
        title?: string;
        collapsable?: boolean;
        sortable?: boolean;
    }>(),
    {
        title: "",
        collapsable: false,
        sortable: false,
    },
);

let isCollapsed = ref(false);
let isCollapsing = ref(false);

function toggleCollapse() {
    isCollapsed.value = !isCollapsed.value;
    isCollapsing.value = true;

    setTimeout(() => (isCollapsing.value = false), 250);
}

provide("isCollapsed", isCollapsed);
</script>
