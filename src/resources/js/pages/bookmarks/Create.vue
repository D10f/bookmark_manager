<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <ButtonLink :to="index_url">
            <IconChevron
                class="rotate-90 group-hover:fill-slate-950 fill-white w-4 h-4 mr-2"
            />
            Back
        </ButtonLink>
    </aside>
    <CardContainer title="Create New Bookmark">
        <form class="px-4 py-2" @submit.prevent="createNewBookmark">
            <BaseInput
                label="Name"
                v-model="form.name"
                :error="form.errors.name"
                autofocus
            />

            <BaseInput
                label="URL"
                v-model="form.url"
                :error="form.errors.url"
            />

            <BaseInput
                label="Category"
                list="categories"
                v-model="form.category"
                :error="form.errors.category"
            />

            <datalist id="categories">
                <option
                    v-for="category in bookmarkStore.categories"
                    :key="category"
                    :value="category"
                >
                    {{ category }}
                </option>
            </datalist>

            <BaseButton :loading="form.processing" class="mt-2" type="submit">
                Submit

                <template #loading> ... </template>
            </BaseButton>
        </form>
    </CardContainer>
</template>

<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { useBookmarkStore } from "@/stores/bookmarks";
import { buildUrl } from "@/helpers/urlExtractor";
// import { Bookmark } from "@/models/Bookmark";
// import { extractDomain, makeCanonical } from "@/helpers/urlExtractor";
import BaseButton from "@/components/BaseButton.vue";
import ButtonLink from "@/components/ButtonLink.vue";
import BaseInput from "@/components/forms/BaseInput.vue";
import CardContainer from "@/components/CardContainer.vue";
import IconChevron from "@/components/icons/IconChevron.vue";

const props = defineProps<{
    index_url: string;
    store_url: string;
}>();

const bookmarkStore = useBookmarkStore();

let form = useForm({
    name: "Test",
    url: "https://devontheroof.top",
    category: "Test",
    favicon_url: "",
});

async function createNewBookmark() {
    form.transform((data) => ({
        ...data,
        url: buildUrl(data.url),
    })).post(props.store_url);
}
</script>

<script lang="ts">
import App from "@/layouts/App.vue";
export default {
    Layout: App,
};
</script>
