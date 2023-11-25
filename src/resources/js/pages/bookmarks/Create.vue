<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <BaseButton :as="Link" :href="index_url">
            <template #leftIcon>
                <IconChevron class="fill-current w-4 h-4 rotate-90" />
            </template>
            Back
        </BaseButton>
    </aside>
    <CardContainer title="Create New Bookmark">
        <form class="px-4 py-2" @submit.prevent="createNewBookmark">
            <div class="py-2 flex flex-col gap-1">
                <BaseInput
                    label="Name"
                    v-model="form.name"
                    :error="form.errors.name"
                    autofocus
                />
            </div>

            <div class="py-2 flex flex-col gap-1">
                <BaseInput
                    label="URL"
                    v-model="form.url"
                    :error="form.errors.url"
                />
            </div>

            <div class="py-2 flex flex-col gap-1">
                <Combobox
                    :options="categories"
                    v-model="form.category"
                    label="Category"
                />
                <!-- <BaseInput -->
                <!--     label="Category" -->
                <!--     list="categories" -->
                <!--     v-model="form.category" -->
                <!--     :error="form.errors.category" -->
                <!-- /> -->
                <!-- <datalist id="categories"> -->
                <!--     <option -->
                <!--         v-for="category in bookmarkStore.categories" -->
                <!--         :key="category" -->
                <!--         :value="category" -->
                <!--     > -->
                <!--         {{ category }} -->
                <!--     </option> -->
                <!-- </datalist> -->
            </div>

            <div class="py-2">
                <BaseButton
                    :loading="form.processing"
                    class="mt-2"
                    type="submit"
                >
                    Submit

                    <template #loading> ... </template>
                </BaseButton>
            </div>
        </form>
    </CardContainer>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import { useBookmarkStore } from "@/stores/bookmarks";
import { buildUrl } from "@/helpers/urlExtractor";
import Combobox from "@/components/Combobox.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseInput from "@/components/BaseInput.vue";
import CardContainer from "@/components/CardContainer.vue";
import IconChevron from "@/components/icons/IconChevron.vue";

const props = defineProps<{
    index_url: string;
    store_url: string;
}>();

const bookmarkStore = useBookmarkStore();

const categories = ref([
    { value: "1", label: "Wade Cooper" },
    { value: "2", label: "Arlene Mccoy" },
    { value: "3", label: "Devon Webb" },
    { value: "4", label: "Tom Cook" },
    { value: "5", label: "Tanya Fox" },
    { value: "6", label: "Hellen Schmidt" },
]);

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
import App from "@/layouts/App.vue";
export default {
    Layout: App,
};
</script>
