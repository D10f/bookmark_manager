<template>
    <header
        class="relative z-50 font-bold text-md text-white bg-slate-950 border-b border-b-slate-700 rounded-md shadow-y shadow-sm shadow-slate-900 p-4 flex justify-between items-center">
        <h3>Welcome back, {{ username }}</h3>

        <div class="flex gap-2 text-xl">
            <BaseButton as="Link" href="#" intent="rounded" @click="showSearchModal = true">
                <Tooltip tooltip="Search bookmarks" position="bottom">
                    <IconSearch class="w-8 h-8 p-2" />
                </Tooltip>
            </BaseButton>

            <!-- <Link href="#"> -->
            <!-- <Tooltip tooltip="Search bookmarks" position="bottom"> -->
            <!--     <IconSearch class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full" /> -->
            <!-- </Tooltip> -->
            <!-- </Link> -->

            <!-- <Link href="#"> -->
            <!--     <Tooltip tooltip="Settings" position="bottom"> -->
            <!--         <IconCog -->
            <!--             class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full" -->
            <!--         /> -->
            <!--     </Tooltip> -->
            <!-- </Link> -->

            <!-- <BaseButton as="a" :href="profileUrl"> -->
            <!--     <Tooltip tooltip="Account" position="bottom"> -->
            <!--         <IconProfile class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full" /> -->
            <!--     </Tooltip> -->
            <!-- </BaseButton> -->

            <!-- <Link :href="profileUrl"> -->
            <!-- <Tooltip tooltip="Account" position="bottom"> -->
            <!--     <IconProfile class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full" /> -->
            <!-- </Tooltip> -->
            <!-- </Link> -->

            <BaseButton as="Link" :href="profileUrl" intent="rounded">
                <Tooltip tooltip="Account" position="bottom">
                    <IconProfile class="w-8 h-8 p-2" />
                </Tooltip>
            </BaseButton>

            <!-- <button class="flex justify-center items-center hover:bg-slate-599 w-8 h-8 p-2 rounded-full"> -->
            <!--     <IconSearch /> -->
            <!-- </button> -->
            <!-- <button class="flex justify-center items-center hover:bg-slate-599 w-8 h-8 p-2 rounded-full"> -->
            <!--     <IconCog /> -->
            <!-- </button> -->
            <!-- <button class="flex justify-center items-center hover:bg-slate-599 w-8 h-8 p-2 rounded-full"> -->
            <!--     <IconProfile /> -->
            <!-- </button> -->

            <Teleport to="body">
                <Modal headless :show="showSearchModal" @close-modal="showSearchModal = false">
                    <template #header>
                        <h3 class="font-md">Search bookmarks</h3>
                    </template>

                    <div class="py-2 flex flex-col gap-1">
                        <BaseInput v-model="searchQuery" ref="searchInput"
                            class="text-xl p-2 focus:outline focus:outline-2 focus:outline-orange-400" />
                    </div>

                    <section>
                        <ul v-if="results.length > 0">
                            <li v-for="result in results" :key="result.item.id">
                                <a :href="result.item.url"
                                    class="block w-full rounded p-1 hover:bg-gray-600 focus:bg-gray-600">
                                    <span class="text-slate-400">{{ result.item.path }} /
                                    </span>
                                    <span class="text-gray-100 font-bold">
                                        {{ result.item.name }}
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </section>

                    <template #footer>
                        <!-- <ul class="DocSearch-Commands"> -->
                        <!--     <li> -->
                        <!--         <kbd -->
                        <!--             class="border border-gray-100 rounded bg-slate-900 p-1 text-xs text-slate-400">Enter</kbd><span -->
                        <!--             class="DocSearch-Label">to select</span> -->
                        <!--     </li> -->
                        <!--     <li> -->
                        <!--         <kbd class="DocSearch-Commands-Key"><svg width="15" height="15" aria-label="Arrow down" -->
                        <!--                 role="img"> -->
                        <!--                 <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" -->
                        <!--                     stroke-width="1.2"> -->
                        <!--                     <path d="M7.5 3.5v8M10.5 8.5l-3 3-3-3"></path> -->
                        <!--                 </g> -->
                        <!--             </svg></kbd><kbd class="DocSearch-Commands-Key"><svg width="15" height="15" -->
                        <!--                 aria-label="Arrow up" role="img"> -->
                        <!--                 <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" -->
                        <!--                     stroke-width="1.2"> -->
                        <!--                     <path d="M7.5 11.5v-8M10.5 6.5l-3-3-3 3"></path> -->
                        <!--                 </g> -->
                        <!--             </svg></kbd><span class="DocSearch-Label">to navigate</span> -->
                        <!--     </li> -->
                        <!--     <li> -->
                        <!--         <kbd class="DocSearch-Commands-Key"><svg width="15" height="15" aria-label="Escape key" -->
                        <!--                 role="img"> -->
                        <!--                 <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" -->
                        <!--                     stroke-width="1.2"> -->
                        <!--                     <path -->
                        <!--                         d="M13.6167 8.936c-.1065.3583-.6883.962-1.4875.962-.7993 0-1.653-.9165-1.653-2.1258v-.5678c0-1.2548.7896-2.1016 1.653-2.1016.8634 0 1.3601.4778 1.4875 1.0724M9 6c-.1352-.4735-.7506-.9219-1.46-.8972-.7092.0246-1.344.57-1.344 1.2166s.4198.8812 1.3445.9805C8.465 7.3992 8.968 7.9337 9 8.5c.032.5663-.454 1.398-1.4595 1.398C6.6593 9.898 6 9 5.963 8.4851m-1.4748.5368c-.2635.5941-.8099.876-1.5443.876s-1.7073-.6248-1.7073-2.204v-.4603c0-1.0416.721-2.131 1.7073-2.131.9864 0 1.6425 1.031 1.5443 2.2492h-2.956"> -->
                        <!--                     </path> -->
                        <!--                 </g> -->
                        <!--             </svg></kbd><span class="DocSearch-Label">to close</span> -->
                        <!--     </li> -->
                        <!-- </ul> -->
                    </template>
                </Modal>
            </Teleport>
        </div>
    </header>
</template>

<script setup lang="ts">
import { computed, ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useFuse } from "@vueuse/integrations/useFuse";
import { onKeyStroke } from "@vueuse/core";
import { useCategoryStore } from "@/stores/category";
import IconProfile from "@/components/icons/IconProfile.vue";
import IconSearch from "@/components/icons/IconSearch.vue";
import IconCog from "@/components/icons/IconCog.vue";
import Tooltip from "@/components/Tooltip.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseInput from "@/components/BaseInput.vue";
import Modal from "@/components/TheModal.vue";

type BookmarkSearchResult = Pick<App.Models.Bookmark, "id" | "name" | "url"> & {
    path: string;
};

const page = usePage<App.Inertia.Middleware>();
const categoryStore = useCategoryStore();

const profileUrl = page.props.profile_url;
const username = page.props.auth?.user.name;

// ----------------------------- Search --------------------------------

const showSearchModal = ref(false);
const searchQuery = ref("");
const searchInput = ref<HTMLInputElement | null>(null);

onKeyStroke("Escape", () => (showSearchModal.value = false));
// onKeyStroke("ArrowDown", () => { });
// onKeyStroke("ArrowUp", () => { });

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
    if (searchInput.value) {
        searchInput.value.focus();
    }
});
</script>
