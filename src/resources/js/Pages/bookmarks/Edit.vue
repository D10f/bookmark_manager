<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <ButtonLink :to="home_url">
            <IconChevron class="rotate-90 group-hover:fill-slate-950 fill-current w-4 h-4 mr-2" />
            Back
        </ButtonLink>
    </aside>
    <CardContainer title="Edit Bookmark">
        <template #actions>
            <button @click="showDeleteModal = true">
                <Tooltip :tooltip="'Delete bookmark'">
                    <IconTrash
                        class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full transition-transform duration-250" />
                </Tooltip>
            </button>

            <Teleport to="body">
                <Modal :show="showDeleteModal" @close-modal="showDeleteModal = false">
                    <template #header>
                        <h3 class="font-md">Delete "{{ bookmark.name }}"?</h3>
                    </template>

                    <p>This action cannot be undone.</p>
                    <template #footer>
                        <div class="flex justify-end items-center gap-2">
                            <BaseButton @click="deleteBookmark" type="submit">
                                Delete
                            </BaseButton>
                            <BaseButton @click="showDeleteModal = false">Cancel</BaseButton>
                        </div>
                    </template>
                </Modal>
            </Teleport>
        </template>

        <form class="px-4 py-2" @submit.prevent="updateBookmark">
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
                <BaseButton :loading="form.processing" class="mt-2" type="submit">
                    Submit

                    <template #loading> ... </template>
                </BaseButton>
            </div>
        </form>
    </CardContainer>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { useCategoryStore } from "@/stores/category";
import { buildUrl } from "@/helpers/urlExtractor";
import Modal from "@/components/TheModal.vue";
import Combobox from "@/components/Combobox.vue";
import BaseButton from "@/components/BaseButton.vue";
import ButtonLink from "@/components/ButtonLink.vue";
import BaseInput from "@/components/BaseInput.vue";
import Tooltip from "@/components/Tooltip.vue";
import CardContainer from "@/components/CardContainer.vue";
import IconChevron from "@/components/icons/IconChevron.vue";
import IconTrash from "@/components/icons/IconTrash.vue";

const props = defineProps<{
    bookmark: App.Models.Bookmark;
    home_url: string;
    update_url: string;
    delete_url: string;
}>();

const categoryStore = useCategoryStore();

let form = useForm({
    name: props.bookmark.name,
    url: props.bookmark.url,
    category: categoryStore.categoryNames.find(
        (category) => category.value === props.bookmark.category_id,
    )!.label,
    // category: categoryStore
    //     .categoryFQDN(
    //         categoryStore.categories.find(
    //             (category) => category.id === props.bookmark.category_id,
    //         )!,
    //     )
    //     .join("/"),
});

async function updateBookmark() {
    form.transform((data) => ({
        ...data,
        category_id: categoryStore.categoryNames.find(
            (c) => c.label === data.category,
        )?.value,
        url: buildUrl(data.url),
    })).post(props.update_url);
}

async function createCategory(categoryName: string) {
    const category = await categoryStore.createCategory(categoryName);
    form.category = categoryStore.categoryFQDN(category).join("/");
}

const showDeleteModal = ref(false);

function deleteBookmark() {
    router.delete(props.delete_url);
}
</script>

<script lang="ts">
import App from "@/layouts/App.vue";
export default {
    Layout: App,
};
</script>
