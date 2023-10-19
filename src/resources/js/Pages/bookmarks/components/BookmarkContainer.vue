<template>
    <section
        class="bg-slate-900 bg-opacity-80 border-b border-b-slate-700 rounded-md shadow-y shadow-sm shadow-slate-900 z-10"
    >
        <header
            class="md:group flex justify-between items-center bg-slate-950 font-bold text-md rounded-t-md p-3"
        >
            <h3>{{ title }}</h3>

            <div
                class="md:opacity-25 md:group-hover:opacity-100 flex gap-3 text-xl"
            >
                <button
                    class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
                >
                    <IconCog />
                </button>
                <button
                    class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
                    @click="() => (isCollapsed = !isCollapsed)"
                >
                    <IconChevron
                        class="transition-transform duration-250"
                        :class="{ 'rotate-180': !isCollapsed }"
                    />
                </button>
            </div>
        </header>

        <div
            class="overflow-scroll transition-all duration-300 px-4 py-2 max-h-[50vh] will-change-auto"
            tabindex="-1"
            :class="{ '!max-h-0 !duration-200 !py-0': isCollapsed }"
        >
            <ul class="flex flex-col gap-2 transition-all" ref="bookmarkList">
                <slot />
            </ul>
        </div>
    </section>
</template>

<script setup lang="ts">
import IconChevron from "@/shared/components/icons/IconChevron.vue";
import IconCog from "@/shared/components/icons/IconCog.vue";
import { provide, ref } from "vue";

defineProps<{ title: string }>();
let isCollapsed = ref(false);

provide("isCollapsed", isCollapsed);
</script>
