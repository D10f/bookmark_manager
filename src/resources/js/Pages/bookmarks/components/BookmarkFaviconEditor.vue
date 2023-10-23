<template>
    <div class="py-2">
        <label class="text-md" v-if="label" :for="label">{{ label }}</label>
        <BookmarkFavicon :icon="icon" />
        <!-- <input -->
        <!--     class="rounded-sm w-full p-1 text-slate-900 focus:outline-0" -->
        <!--     :id="label" -->
        <!--     :value="modelValue" -->
        <!--     v-bind="$attrs" -->
        <!--     @input="$emit('update:modelValue', $event.target.value)" -->
        <!-- /> -->
    </div>
</template>

<script setup lang="ts">
import BookmarkFavicon from "@/Pages/bookmarks/components/BookmarkFavicon.vue";
import { Favicon } from "@/models/Favicon";

defineProps<{ label?: string; icon: Favicon | null }>();
defineEmits<{
    "update:modelValue": [newValue: string];
}>();
</script>
