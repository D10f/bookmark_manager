<template>
    <CardContainer title="Account" collapsable>
        <template #actions>
            <BaseButton intent="rounded" @click="logoutProfile" aria-label="logout">
                <Tooltip tooltip="Log out">
                    <IconLogout class="w-8 h-8 p-2" />
                </Tooltip>
            </BaseButton>

            <BaseButton intent="rounded" @click="showDeleteModal = true" aria-label="delete account">
                <Tooltip tooltip="Delete account">
                    <IconTrash class="w-8 h-8 p-2" />
                </Tooltip>
            </BaseButton>

            <Teleport to="body">
                <Modal :show="showDeleteModal" @close-modal="showDeleteModal = false">
                    <template #header>
                        <h3 class="font-md">Delete Account?</h3>
                    </template>

                    <template #footer>
                        <div
                            class="m-4 px-4 py-2 border-l-2 border-red-400 bg-gray-100/20 rounded-tr-md rounded-br-md text-red-200">
                            <h3 class="text-2xl font-bold">Caution!</h3>
                            <p class="text-lg">This action cannot be undone.</p>
                        </div>

                        <form class="px-4 py-2" @submit.prevent="deleteProfile">
                            <div class="py-2 flex flex-col gap-1">
                                <BaseInput label="Enter the following text below to proceed:" disabled
                                    v-model="deleteForm.validationPhrase"
                                    class="font-bold uppercase bg-transparent !text-cyan-400 text-2xl px-2 pt-2" />
                            </div>

                            <div class="py-2 flex flex-col gap-1">
                                <BaseInput label="Confirm" v-model="deleteForm.confirmValidation" class="uppercase" />
                            </div>

                            <div class="py-2">
                                <BaseButton :loading="form.processing" :disabled="!isDeleteBtnActive" class="mt-2"
                                    type="submit">
                                    Delete Profile
                                    <template #loading> ... </template>
                                </BaseButton>
                            </div>
                        </form>
                    </template>
                </Modal>
            </Teleport>
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
                <BaseButton :loading="form.processing" :disabled="allowUpdate" class="mt-2" type="submit">
                    Update Profile
                    <template #loading> ... </template>
                </BaseButton>
            </div>
        </form>
    </CardContainer>
</template>

<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import BaseInput from "@/components/BaseInput.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardContainer from "@/components/CardContainer.vue";
import Modal from "@/components/TheModal.vue";
import Tooltip from "@/components/Tooltip.vue";
import IconLogout from "@/components/icons/IconLogout.vue";
import IconTrash from "@/components/icons/IconTrash.vue";

const props = defineProps<{
    user: App.Models.User;
    delete_confirmation: string;
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

const allowUpdate = computed(
    () =>
        form.name === props.user.name &&
        form.email === props.user.email &&
        form.password === "" &&
        form.password_confirmation === "",
);

/** ------------------------ Delete --------------------------------- */

const showDeleteModal = ref(false);

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
