<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <BaseButton as="Link" :href="home_url">
            <IconChevron class="rotate-90 fill-current w-4 h-4" />
            Back
        </BaseButton>
    </aside>

    <CardContainer title="Edit Profile">
        <template #actions>
            <!-- <button @click="logoutProfile" aria-label="Logout"> -->
            <!--     <Tooltip tooltip="Logout" aria-hidden="true"> -->
            <!--         <IconLogout aria-hidden="true" -->
            <!--             class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full transition-transform duration-250" /> -->
            <!--     </Tooltip> -->
            <!-- </button> -->

            <BaseButton intent="rounded" @click="logoutProfile" aria-label="logout">
                <Tooltip tooltip="Log out">
                    <IconLogout class="w-8 h-8 p-2" />
                </Tooltip>
            </BaseButton>

            <BaseButton intent="rounded" @click="toggleDeletePrompt" aria-label="delete account">
                <Tooltip tooltip="Delete account">
                    <IconTrash v-if="!showDeleteConfirmation" class="w-8 h-8 p-2" />
                    <div v-else class="w-8 h-8 text-2xl">&times;</div>
                </Tooltip>
            </BaseButton>

            <!-- <Teleport to="body"> -->
            <!--     <Modal :show="showDeleteModal" @close-modal="showDeleteModal = false"> -->
            <!--         <template #header> -->
            <!--             <h3 class="font-md">Delete "{{ user.name }}"?</h3> -->
            <!--         </template> -->

            <!--         <p>This action cannot be undone.</p> -->
            <!--         <template #footer> -->
            <!--             <div class="flex justify-end items-center gap-2"> -->
            <!--                 <BaseButton @click="deleteProfile" type="submit"> -->
            <!--                     Delete -->
            <!--                 </BaseButton> -->
            <!--                 <BaseButton intent="text" @click="showDeleteModal = false">Cancel</BaseButton> -->
            <!--             </div> -->
            <!--         </template> -->
            <!--     </Modal> -->
            <!-- </Teleport> -->
        </template>

        <form class="px-4 py-2" @submit.prevent="updateProfile">
            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Username" v-model="form.name" :error="form.errors.name" autofocus />
            </div>

            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Email" v-model="form.email" :error="form.errors.email" autofocus />
            </div>

            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Password" v-model="form.password" :error="form.errors.password" autofocus />
            </div>

            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Confirm Password" v-model="form.password_confirmation"
                    :error="form.errors.password_confirmation" autofocus />
            </div>

            <div class="py-2">
                <BaseButton :loading="form.processing" class="mt-2" type="submit">
                    Update Profile
                    <template #loading> ... </template>
                </BaseButton>
            </div>
        </form>
    </CardContainer>

    <CardContainer title="Delete Profile" v-show="showDeleteConfirmation">
        <!-- <template #actions> -->
        <!--     <button @click="showDeleteModal = true"> -->
        <!--         <Tooltip :tooltip="'Delete Profile'"> -->
        <!--             <IconTrash -->
        <!--                 class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full transition-transform duration-250" /> -->
        <!--         </Tooltip> -->
        <!--     </button> -->
        <!-- </template> -->

        <div class="m-4 px-4 py-2 border-l-2 border-red-400 bg-gray-100/20 rounded-tr-md rounded-br-md text-red-200">
            <h3 class="text-2xl font-bold">Caution!</h3>
            <p class="text-lg">This action cannot be undone.</p>
        </div>

        <form class="px-4 py-2" @submit.prevent="deleteProfile">
            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Enter the following text below to proceed:" disabled v-model="deleteForm.validationPhrase"
                    class="font-bold uppercase bg-transparent !text-cyan-400 text-2xl px-2 pt-2" />
            </div>

            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Confirm" v-model="deleteForm.confirmValidation" class="uppercase" />
            </div>

            <div class="py-2">
                <BaseButton :loading="form.processing" :disabled="!isDeleteBtnActive" class="mt-2" type="submit">
                    Delete Profile
                    <template #loading> ... </template>
                </BaseButton>
            </div>
        </form>
    </CardContainer>
</template>

<script setup lang="ts">
import { computed, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import BaseButton from "@/components/BaseButton.vue";
import BaseInput from "@/components/BaseInput.vue";
import CardContainer from "@/components/CardContainer.vue";
import Modal from "@/components/TheModal.vue";
import Tooltip from "@/components/Tooltip.vue";
import IconChevron from "@/components/icons/IconChevron.vue";
import IconLogout from "@/components/icons/IconLogout.vue";

const props = defineProps<{
    user: App.Models.User;
    delete_confirmation: string;
    home_url: string;
    update_url: string;
    delete_url: string;
    logout_url: string;
}>();

/** ------------------------ Update --------------------------------- */

const form = useForm({
    name: props.user.name ?? "",
    email: props.user.email,
    password: "",
    password_confirmation: "",
});

function updateProfile() {
    form.post(props.update_url);
}

/** ------------------------ Delete --------------------------------- */

const showDeleteConfirmation = ref(false);

function toggleDeletePrompt() {
    showDeleteConfirmation.value = !showDeleteConfirmation.value;
}

const isDeleteBtnActive = computed(
    () =>
        deleteForm.validationPhrase.toLowerCase() ===
        deleteForm.confirmValidation.toLowerCase(),
);

const deleteForm = useForm({
    validationPhrase: props.delete_confirmation,
    confirmValidation: "",
});

function deleteProfile() {
    deleteForm.delete(props.delete_url);
}

/** ------------------------ Logout --------------------------------- */

function logoutProfile() {
    form.post(props.logout_url);
}
</script>

<script lang="ts">
import App from "@/layouts/App.vue";
import IconTrash from "@/components/icons/IconTrash.vue";
export default {
    layout: App,
};
</script>
