<template>
    <Teleport to="body">
        <Modal :show="show" @closeModal="$emit('closeModal')">
            <template #header>
                <h1>Create New Bookmark</h1>
            </template>

            <form @submit.prevent="createNewBookmark">
                <BaseInput label="Name" v-model="name" />

                <BaseInput label="URL" v-model="url" />

                <BaseInput label="Category" list="categories" v-model="category" />

                <datalist id="categories">
                    <option v-for="category in bookmarkStore.categories" :key="category" :value="category">
                        {{ category }}
                    </option>
                </datalist>

                <BaseButton :loading="loading" class="mt-2" type="submit">Submit
                </BaseButton>
            </form>
        </Modal>
    </Teleport>
</template>

<script setup lang="ts">
import Modal from "@/shared/components/TheModal.vue";
import BaseInput from "@/shared/components/forms/BaseInput.vue";
import BaseButton from "@/shared/components/BaseButton.vue";
import { ref } from "vue";
import { useBookmarkStore } from "@/stores/bookmarks";
import { Bookmark } from "@/models/Bookmark";

const bookmarkStore = useBookmarkStore();

defineProps<{ show: boolean }>();
defineEmits<{
    submitCreateBookmark: [title: string, url: string, category: string];
}>();
const name = ref("");
const url = ref("");
const category = ref("");
let loading = ref(false);

async function createNewBookmark() {
    loading.value = true;

    try {
        const response = await fetch(`/api/favicon/${url.value}`);
        const responseType = response.headers.get("content-type");
        let favicon: string | ArrayBuffer;

        if (responseType?.includes("text/plain")) {
            favicon = await response.text();
        } else if (responseType?.includes("application/octet-stream")) {
            favicon = await response.arrayBuffer();
        } else {
            throw new Error("Unable to determine response type.");
        }

        const bookmark = new Bookmark(name.value, url.value, favicon);
        bookmarkStore.create(bookmark, category.value);
    } catch (e) {
    } finally {
        name.value = "";
        url.value = "";
        category.value = "";
        loading.value = false;
    }
}
</script>
