<template>
    <aside class="flex justify-end items-center mt-2 z-10">
        <BaseButton as="a" :href="home_url">
            <IconChevron class="rotate-90 group-hover:fill-slate-950 fill-current w-4 h-4 mr-2" />
            Back
        </BaseButton>
    </aside>

    <CardContainer title="Edit Profile">
        <template #actions>
            <button @click="logoutProfile" aria-label="Logout">
                <Tooltip tooltip="Logout" aria-hidden="true">
                    <IconLogout aria-hidden="true"
                        class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full transition-transform duration-250" />
                </Tooltip>
            </button>

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

    <CardContainer title="Delete Profile">
        <!-- <template #actions> -->
        <!--     <button @click="showDeleteModal = true"> -->
        <!--         <Tooltip :tooltip="'Delete Profile'"> -->
        <!--             <IconTrash -->
        <!--                 class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full transition-transform duration-250" /> -->
        <!--         </Tooltip> -->
        <!--     </button> -->
        <!-- </template> -->

        <div class="px-4 py-2">
            <h3>Caution!</h3>
            <p>This action cannot be undone.</p>
            <p>Please enter the following text below to proceed.</p>
        </div>

        <form class="px-4 py-2" @submit.prevent="deleteProfile">
            <div class="py-2 flex flex-col gap-1">
                <BaseInput disabled v-model="deleteForm.validationPhrase"
                    class="bg-transparent text-cyan-400 text-2xl text-center" />
            </div>

            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Confirm" v-model="deleteForm.confirmValidation" />
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

const isDeleteBtnActive = computed(
    () => deleteForm.validationPhrase === deleteForm.confirmValidation,
);

const deleteForm = useForm({
    validationPhrase: "hello world",
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
export default {
    layout: App,
};
</script>