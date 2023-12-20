<template>
    <li class="group/item flex justify-between items-center gap-2 rounded-md px-2 py-1 hover:bg-slate-100/10">
        <div class="h-8 w-8 mr-2 drag-handle">
            <img src="/folder.png" />
        </div>

        <button class="text-lg text-left w-full h-full hover:text-yellow-500" :tabIndex="isCollapsed ? -1 : 0"
            @click="$emit('activateCategory', category)">
            {{ category.title }}
        </button>

        <!-- <Link :href="category.edit_url!" :tabIndex="isCollapsed ? -1 : 0"> -->
        <!-- <IconPencil class="flex justify-center items-center w-10 h-8 hover:bg-slate-600 p-2 rounded-full" /> -->
        <!-- </Link> -->
    </li>
</template>

<script setup lang="ts">
import IconPencil from "@/components/icons/IconPencil.vue";
import IconFolder from "@/components/icons/IconFolder.vue";
import { inject } from "vue";

defineProps<{ category: App.Models.Category }>();
defineEmits<{ activateCategory: [category: App.Models.Category] }>();
const isCollapsed = inject("isCollapsed");
</script>
