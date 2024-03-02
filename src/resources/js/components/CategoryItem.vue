<template>
    <li class="group/item flex justify-between items-center gap-2 rounded-md px-2 py-1 hover:bg-slate-100/10"
        :class="{ 'bg-yellow-500/40': draggingOver }" @dragstart="handleDragStart" @dragenter="handleDragEnter"
        @dragleave="handleDragLeave" @drop="handleDrop">
        <div data-drag-handle="bookmarkItemHandle" class="h-8 w-8 mr-2 drag-handle"
            :class="{ 'pointer-events-none': draggingOver }">
            <img src="/folder.png" />
        </div>

        <button class="text-lg text-left overflow-hidden whitespace-nowrap w-full h-full hover:text-yellow-500"
            :class="{ 'pointer-events-none': draggingOver }" :tabindex="isCollapsed ? -1 : 0"
            @click="$emit('activateCategory', category)">
            {{ category.title }}
        </button>

        <!-- <Link :href="category.edit_url!" :tabIndex="isCollapsed ? -1 : 0"> -->
        <!-- <IconPencil class="flex justify-center items-center w-10 h-8 hover:bg-slate-600 p-2 rounded-full" /> -->
        <!-- </Link> -->
    </li>
</template>

<script setup lang="ts">
import { inject, ref } from "vue";
import { useDragStore } from "@/stores/drag";
import IconPencil from "@/components/icons/IconPencil.vue";
import IconFolder from "@/components/icons/IconFolder.vue";

const props = defineProps<{ category: App.Models.Category }>();
const emit = defineEmits<{
    activateCategory: [category: App.Models.Category];
    dropItem: [category: App.Models.Category];
}>();
const isCollapsed = inject("isCollapsed");
const isDragging = ref(false);
const draggingOver = ref(false);

const dragStore = useDragStore();

function handleDrop() {
    if (!isDragging.value) {
        emit("dropItem", props.category);
    }
    draggingOver.value = false;
    isDragging.value = false;
}
function handleDragStart() {
    isDragging.value = true;
    dragStore.item = props.category;
}
function handleDragEnter() {
    if (!dragStore.item || isDragging.value) return;
    // dragStore.dragArea = props.category.id;
    draggingOver.value = true;
}
function handleDragLeave() {
    // dragStore.dragArea = -1;
    draggingOver.value = false;
}
</script>
