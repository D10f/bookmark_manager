<template>
    <CardContainer title="Login with keyfile" class="mt-2">
        <template #actions>
            <Link :href="auth_register">
            <Tooltip tooltip="Don't have an account?" position="bottom">
                <IconProfile class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full" />
            </Tooltip>
            </Link>
            <Link :href="auth_login">
            <Tooltip tooltip="Login with password" position="bottom">
                <IconPassword class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full" />
            </Tooltip>
            </Link>
        </template>
        <form class="px-4 py-2" @submit.prevent="submitForm">
            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Email" v-model="form.email" autofocus :error="form.errors.email" />
            </div>

            <div class="py-2">
                <BaseButton :loading="form.processing" :leftIcon="IconProfile" class="mt-2" type="submit">
                    Select File
                </BaseButton>
            </div>
        </form>
    </CardContainer>
</template>

<script setup lang="ts">
import App from "@/layouts/App.vue";
import BaseInput from "@/components/BaseInput.vue";
import BaseButton from "@/components/BaseButton.vue";
import Tooltip from "@/components/Tooltip.vue";
import CardContainer from "@/components/CardContainer.vue";
import IconProfile from "@/components/icons/IconProfile.vue";
import IconPassword from "@/components/icons/IconPassword.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps<{
    auth_register: string;
    auth_login: string;
    auth_verify: string;
}>();

const form = useForm({
    email: "",
    keyfile: null,
});

function submitForm() {
    fetch("/sanctum/csrf-cookie").then(() => {
        form.post(props.auth_verify);
    });
}
</script>

<script lang="ts">
export default {
    layout: App,
};
</script>
