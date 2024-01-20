<template>
    <template v-for="breadcrumb in breadcrumbs" :key="breadcrumb.id">
        <button
            class="text-gray-500 hover:text-yellow-500"
            @click="$emit('activateCategory', breadcrumb)"
        >
            {{ breadcrumb.title }}
        </button>
        <span class="text-gray-500 mx-1">/</span>
    </template>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { useCategoryStore } from "@/stores/category";

const props = defineProps<{ category: App.Models.Category }>();
defineEmits<{ activateCategory: [category: App.Models.Category] }>();

const categoryStore = useCategoryStore();

const breadcrumbs = computed(() =>
    categoryStore.getCategoryTree(props.category).slice(0, -1),
);
</script>
