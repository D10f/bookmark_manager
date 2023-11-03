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
import { buildUrl } from "@/shared/helpers/urlExtractor";
// import { Bookmark } from "@/models/Bookmark";
// import { extractDomain, makeCanonical } from "@/shared/helpers/urlExtractor";
import BaseButton from "@/shared/components/BaseButton.vue";
import ButtonLink from "@/shared/components/ButtonLink.vue";
import BaseInput from "@/shared/components/forms/BaseInput.vue";
import CardContainer from "@/shared/components/CardContainer.vue";
import IconChevron from "@/shared/components/icons/IconChevron.vue";

const props = defineProps<{
    index_url: string;
    store_url: string;
}>();

const bookmarkStore = useBookmarkStore();

let form = useForm({
    name: "",
    url: "",
    category: "",
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
import App from "@/shared/layouts/App.vue";
export default {
    Layout: App,
};
</script>
