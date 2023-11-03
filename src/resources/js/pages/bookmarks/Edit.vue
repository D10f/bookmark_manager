<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <ButtonLink :to="index_url">
            <IconChevron class="rotate-90 group-hover:fill-slate-950 fill-white w-4 h-4 mr-2" />
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
            <BaseInput label="Name" v-model="form.name" :error="form.errors.name" />

            <BaseInput label="URL" v-model="form.url" :error="form.errors.url" />

            <BaseInput label="Category" list="categories" v-model="form.category" :error="form.errors.category" />

            <datalist id="categories">
                <option v-for="category in bookmarkStore.categories" :key="category" :value="category">
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
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { useBookmarkStore } from "@/stores/bookmarks";
import { buildUrl } from "@/shared/helpers/urlExtractor";
import { Bookmark } from "@/models/Bookmark";
import Modal from "@/shared/components/TheModal.vue";
import BaseButton from "@/shared/components/BaseButton.vue";
import ButtonLink from "@/shared/components/ButtonLink.vue";
import BaseInput from "@/shared/components/forms/BaseInput.vue";
import Tooltip from "@/shared/components/Tooltip.vue";
import CardContainer from "@/shared/components/CardContainer.vue";
import IconChevron from "@/shared/components/icons/IconChevron.vue";
import IconTrash from "@/shared/components/icons/IconTrash.vue";

const props = defineProps<{
    bookmark: Bookmark;
    index_url: string;
    edit_url: string;
    delete_url: string;
}>();

const bookmarkStore = useBookmarkStore();
const showDeleteModal = ref(false);

let form = useForm({
    name: props.bookmark.name,
    url: props.bookmark.url,
    category: props.bookmark.category,
});

async function updateBookmark() {
    form.transform((data) => ({
        ...data,
        url: buildUrl(data.url),
    })).post(props.edit_url);
}

function deleteBookmark() {
    router.delete(props.delete_url);
}
</script>

<script lang="ts">
import App from "@/shared/layouts/App.vue";
export default {
    Layout: App,
};
</script>
