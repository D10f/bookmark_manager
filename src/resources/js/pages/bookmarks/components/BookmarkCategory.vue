<template>
    <CardContainer collapsable :title="category">
        <template #actions>
            <Link href="#">
                <Tooltip tooltip="Bookmark Settings" :showTooltip="false">
                    <IconCog
                        class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
                    />
                </Tooltip>
            </Link>
        </template>

        <ul class="flex flex-col gap-2 transition-all">
            <slot />
        </ul>
    </CardContainer>
</template>

<script setup lang="ts">
import { Bookmark } from "@/models/Bookmark";
import Tooltip from "@/shared/components/Tooltip.vue";
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
