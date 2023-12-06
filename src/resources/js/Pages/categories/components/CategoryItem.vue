<template>
    <li
        class="group/item flex justify-between items-center gap-2 rounded-md py-1"
    >
        <div class="h-8 w-8 mr-2 drag-handle">
            <IconFolder />
        </div>

        <button
            class="text-lg text-left w-full h-full hover:text-yellow-500"
            :tabIndex="isCollapsed ? -1 : 0"
            @click="$emit('activateCategory', category)"
        >
            {{ category.title }}
        </button>

        <Link href="#" :tabIndex="isCollapsed ? -1 : 0">
            <IconPencil
                class="flex justify-center items-center w-10 h-8 hover:bg-slate-600 p-2 rounded-full"
            />
        </Link>
    </li>
</template>

<script setup lang="ts">
import IconPencil from "@/components/icons/IconPencil.vue";
import IconFolder from "@/components/icons/IconFolder.vue";
import { Category } from "@/types/category";
import { inject } from "vue";

defineProps<{ category: Category }>();
defineEmits<{ activateCategory: [category: Category] }>();
const isCollapsed = inject("isCollapsed");
</script>
