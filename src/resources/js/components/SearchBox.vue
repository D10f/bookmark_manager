<template>
    <BaseButton intent="rounded" @click="showSearchModal = true">
        <Tooltip tooltip="Search bookmarks" position="bottom">
            <IconSearch class="w-8 h-8 p-2" />
        </Tooltip>
    </BaseButton>

    <Teleport to="body">
        <Modal headless :show="showSearchModal" @close-modal="showSearchModal = false">
            <template #header>
                <h3 class="font-md">Search bookmarks</h3>
            </template>

            <div class="py-2 flex flex-col items-start gap-1">
                <BaseInput v-model="searchQuery" ref="searchInput"
                    class="text-xl p-2 focus:outline focus:outline-2 focus:outline-orange-400" />
            </div>

            <section class="min-h-[15vh]">
                <ul v-if="results.length > 0">
                    <SearchBoxResult v-for="(result, idx) in results" :key="result.item.id" :isSelected="idx === cursorIdx"
                        :result="result.item" @mouseenter="cursorIdx = idx" @focus="cursorIdx = idx" />
                </ul>
            </section>

            <template #footer></template>
        </Modal>
    </Teleport>
</template>

<script setup lang="ts">
import { computed, ref, watch } from "vue";
import { useFuse } from "@vueuse/integrations/useFuse";
import { onKeyStroke, useKeyModifier } from "@vueuse/core";
import { useCategoryStore } from "@/stores/category";
import BaseInput from "@/components/BaseInput.vue";
import BaseButton from "@/components/BaseButton.vue";
import SearchBoxResult from "@/components/SearchBoxResult.vue";
import Modal from "@/components/TheModal.vue";
import Tooltip from "@/components/Tooltip.vue";
import IconSearch from "@/components/icons/IconSearch.vue";

export type BookmarkSearchResult = Pick<
    App.Models.Bookmark,
    "id" | "name" | "url"
> & {
    path: string;
};

const categoryStore = useCategoryStore();
const showSearchModal = ref(false);
const searchQuery = ref("");
const searchInput = ref<HTMLInputElement | null>(null);
const cursorIdx = ref(0);
const ctrl = useKeyModifier("Control");

onKeyStroke(["k", "K"], (e: KeyboardEvent) => {
    if (!ctrl.value) return;
    e.preventDefault();
    showSearchModal.value = true;
});
onKeyStroke("Escape", () => {
    showSearchModal.value = false;
    searchQuery.value = "";
    cursorIdx.value = 0;
});
onKeyStroke("ArrowDown", () => {
    cursorIdx.value = (cursorIdx.value + 1) % results.value.length;
});
onKeyStroke("ArrowUp", () => {
    if (cursorIdx.value <= 0) {
        cursorIdx.value = results.value.length - 1;
    } else {
        cursorIdx.value = cursorIdx.value - (1 % results.value.length);
    }
});

const bookmarks = computed(() => {
    const results: BookmarkSearchResult[] = [];

    for (const category of categoryStore.categories) {
        const path = categoryStore.categoryFQDN(category).join(" / ");
        for (const { id, name, url } of category.bookmarks) {
            results.push({ id, path, name, url });
        }
    }

    return results;
});

const { results } = useFuse(searchQuery, bookmarks, {
    fuseOptions: {
        keys: ["name", "path", "url"],
        minMatchCharLength: 2,
        threshold: 0.5,
    },
    resultLimit: 10,
});

watch(showSearchModal, () => {
    searchInput?.value?.focus();
});
</script>
