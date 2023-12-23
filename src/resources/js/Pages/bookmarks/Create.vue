<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <BaseButton as="Link" :href="home_url">
            <IconChevron class="rotate-90 fill-current w-4 h-4" />
            Back
        </BaseButton>
        <!-- <BaseButton :as="Link" :href="home_url"> -->
        <!--     <template #leftIcon> -->
        <!--         <IconChevron class="fill-current w-4 h-4 rotate-90" /> -->
        <!--     </template> -->
        <!--     Back -->
        <!-- </BaseButton> -->
    </aside>
    <CardContainer title="Create New Bookmark">
        <form class="px-4 py-2" @submit.prevent="createNewBookmark">
            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Name" v-model="form.name" :error="form.errors.name" autofocus />
            </div>

            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="URL" v-model="form.url" :error="form.errors.url" />
            </div>

            <div class="py-2 flex flex-col gap-1">
                <Combobox :options="categoryStore.categoryNames" :createOption="createCategory" v-model="form.category"
                    label="Category" />
            </div>

            <div class="py-2">
                <BaseButton :loading="isLoading || form.processing" class="mt-2" type="submit">
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
import { useCategoryStore } from "@/stores/category";
import { buildUrl } from "@/helpers/urlExtractor";
import Combobox from "@/components/Combobox.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseInput from "@/components/BaseInput.vue";
import CardContainer from "@/components/CardContainer.vue";
import IconChevron from "@/components/icons/IconChevron.vue";

const props = defineProps<{
    categories: App.Models.Category[];
    home_url: string;
    store_url: string;
}>();

const categoryStore = useCategoryStore();

const form = useForm({
    name: "",
    url: "",
    category: "",
});

let isLoading = ref(false);

async function createNewBookmark() {
    form.transform((data) => ({
        ...data,
        category_id: categoryStore.categoryNames.find(
            (c) => c.label === data.category,
        )?.value,
        url: buildUrl(data.url),
    })).post(props.store_url);
}

async function createCategory(categoryName: string) {
    try {
        isLoading.value = true;
        const category = await categoryStore.createCategory(categoryName);
        form.category = categoryStore.categoryFQDN(category).join("/");
    } catch (e) {
    } finally {
        isLoading.value = false;
    }
}
</script>

<script lang="ts">
import App from "@/layouts/App.vue";
export default {
    Layout: App,
};
</script>
