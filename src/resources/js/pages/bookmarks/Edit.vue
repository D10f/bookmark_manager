<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <ButtonLink to="/">
            <IconChevron
                class="rotate-90 group-hover:fill-slate-950 fill-white w-4 h-4 mr-2"
            />
            Back
        </ButtonLink>
    </aside>
    <CardContainer title="Edit Bookmark">
        <form class="px-4 py-2" @submit.prevent="">
            <BaseInput label="Name" v-model="name" />

            <BaseInput label="URL" v-model="url" />

            <BaseInput label="Category" list="categories" v-model="category" />

            <datalist id="categories">
                <option
                    v-for="category in bookmarkStore.categories"
                    :key="category"
                    :value="category"
                >
                    {{ category }}
                </option>
            </datalist>

            <BaseButton :loading="loading" class="mt-2" type="submit"
                >Submit</BaseButton
            >
        </form>
    </CardContainer>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useBookmarkStore } from "@/stores/bookmarks";
import { Bookmark } from "@/models/Bookmark";
import BaseButton from "@/shared/components/BaseButton.vue";
import ButtonLink from "@/shared/components/ButtonLink.vue";
import BaseInput from "@/shared/components/forms/BaseInput.vue";
import CardContainer from "@/shared/components/CardContainer.vue";
import IconChevron from "@/shared/components/icons/IconChevron.vue";

const bookmarkStore = useBookmarkStore();
const name = ref("");
const url = ref("");
const category = ref("");
let loading = ref(false);

// async function createNewBookmark() {
//     loading.value = true;

//     try {
//         const response = await fetch(`/api/favicon/${url.value}`);
//         const favicon = await response.arrayBuffer();
//         const bookmark = new Bookmark(name.value, url.value, favicon);
//         bookmarkStore.createBookmark(bookmark, category.value);
//     } catch (e) {
//         console.log((e as Error).message);
//     } finally {
//         name.value = "";
//         url.value = "";
//         category.value = "";
//         loading.value = false;
//     }
// }
</script>

<script lang="ts">
import App from "@/shared/layouts/App.vue";
export default {
    Layout: App,
};
</script>
