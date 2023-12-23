<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <BaseButton as="Link" :href="home_url">
            <IconChevron class="rotate-90 fill-current w-4 h-4" />
            Back
        </BaseButton>
        <!-- <ButtonLink :to="home_url"> -->
        <!--     <IconChevron class="rotate-90 group-hover:fill-slate-950 fill-current w-4 h-4 mr-2" /> -->
        <!--     Back -->
        <!-- </ButtonLink> -->
    </aside>
    <CardContainer title="Edit Category">
        <template #actions>
            <!-- <button @click="showDeleteModal = true"> -->
            <!--     <Tooltip :tooltip="'Delete category'"> -->
            <!--         <IconTrash -->
            <!--             class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full transition-transform duration-250" /> -->
            <!--     </Tooltip> -->
            <!-- </button> -->
            <BaseButton intent="rounded" @click="showDeleteModal = true">
                <Tooltip tooltip="Delete category">
                    <IconTrash class="w-8 h-8 p-2" />
                </Tooltip>
            </BaseButton>

            <Teleport to="body">
                <Modal :show="showDeleteModal" @close-modal="showDeleteModal = false">
                    <template #header>
                        <h3 class="font-md">Delete "{{ category.title }}"?</h3>
                    </template>

                    <p>This action cannot be undone.</p>
                    <template #footer>
                        <div class="flex justify-end items-center gap-2">
                            <BaseButton @click="deleteCategory" type="submit">
                                Delete
                            </BaseButton>
                            <BaseButton intent="text" @click="showDeleteModal = false">Cancel</BaseButton>
                        </div>
                    </template>
                </Modal>
            </Teleport>
        </template>

        <form class="px-4 py-2" @submit.prevent="updateCategory">
            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Name" v-model="form.title" :error="form.errors.title" autofocus />
            </div>

            <!-- <div class="py-2 flex flex-col gap-1"> -->
            <!--     <Combobox :options="categoryStore.categoryNames" :createOption="() => { }" v-model="form.category" -->
            <!--         label="Parent Category" /> -->
            <!-- </div> -->

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
import BaseButton from "@/components/BaseButton.vue";
import Combobox from "@/components/Combobox.vue";
import ButtonLink from "@/components/ButtonLink.vue";
import BaseInput from "@/components/BaseInput.vue";
import Tooltip from "@/components/Tooltip.vue";
import CardContainer from "@/components/CardContainer.vue";
import IconChevron from "@/components/icons/IconChevron.vue";
import IconTrash from "@/components/icons/IconTrash.vue";

const props = defineProps<{
    category: App.Models.Category;
    home_url: string;
    update_url: string;
    delete_url: string;
}>();

const categoryStore = useCategoryStore();
const showDeleteModal = ref(false);

let form = useForm({
    title: props.category.title,
    category: categoryStore.categoryNames.find(
        (c) => c.value === props.category.parent_id,
    )?.label,
});

async function updateCategory() {
    form.transform((data) => ({
        ...props.category,
        ...data,
    })).post(props.update_url);
}

function deleteCategory() {
    router.delete(props.delete_url);
}
</script>

<script lang="ts">
import App from "@/layouts/App.vue";
export default {
    Layout: App,
};
</script>
