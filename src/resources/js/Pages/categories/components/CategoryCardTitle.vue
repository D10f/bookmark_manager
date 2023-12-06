<template>
    <button
        v-for="breadcrumb in breadcrumbs"
        :key="breadcrumb.id"
        @click="$emit('activateCategory', breadcrumb)"
    >
        {{ breadcrumb.title }}
    </button>
    <span class="mx-1">/</span>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { useCategoryStore } from "@/stores/category";
import { Category } from "@/types/category";

const props = defineProps<{ category: Category }>();
defineEmits<{ activateCategory: [category: Category] }>();

const categoryStore = useCategoryStore();

const breadcrumbs = computed(() =>
    categoryStore.getCategoryTree(props.category).slice(0, -1),
);
</script>
