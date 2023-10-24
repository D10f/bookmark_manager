<template>
    <CardContainer collapsable :title="category">
        <template #actions>
            <button
                class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
            >
                <IconCog />
            </button>
        </template>

        <ul class="flex flex-col gap-2 transition-all">
            <slot />
        </ul>
    </CardContainer>
</template>
<!-- <button -->
<!--     class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full" -->
<!--     @click="() => (isCollapsed = !isCollapsed)" -->
<!-- > -->
<!--     <IconChevron -->
<!--         class="transition-transform duration-250" -->
<!--         :class="{ 'rotate-180': !isCollapsed }" -->
<!--     /> -->
<!-- </button> -->
<!-- <div -->
<!--     class="overflow-scroll transition-all duration-300 px-4 py-2 max-h-[50vh] will-change-auto" -->
<!--     tabindex="-1" -->
<!--     :class="{ -->
<!--         '!max-h-0 !duration-200 !py-0 !overflow-hidden': isCollapsed, -->
<!--     }" -->
<!-- > -->
<!--     <ul class="flex flex-col gap-2 transition-all" ref="bookmarkList"> -->
<!--         <slot /> -->
<!--     </ul> -->
<!-- </div> -->

<script setup lang="ts">
import { Bookmark } from "@/models/Bookmark";
// import IconChevron from "@/shared/components/icons/IconChevron.vue";
import IconCog from "@/shared/components/icons/IconCog.vue";
import CardContainer from "@/shared/components/CardContainer.vue";
import { provide, ref } from "vue";

defineProps<{ category: string }>();
defineEmits<{
    showEditModal: [bookmark: Bookmark];
}>();
let isCollapsed = ref(false);

provide("isCollapsed", isCollapsed);
</script>
