<template>
    <CardContainer title="Forgot Password?" class="mt-2">
        <template #actions>
            <Link :href="auth_login">
            <Tooltip tooltip="Already have an account?" position="top">
                <IconProfile class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full" />
            </Tooltip>
            </Link>
        </template>
        <form class="px-4 py-2" @submit.prevent="submitForm">
            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Email" v-model="form.email" autofocus :error="form.errors.email" />
            </div>

            <div class="py-2">
                <BaseButton :loading="form.processing" :leftIcon="IconProfile" class="mt-2" type="submit">
                    Send Email
                </BaseButton>
            </div>
        </form>
    </CardContainer>
</template>

<script setup lang="ts">
import BaseInput from "@/components/BaseInput.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardContainer from "@/components/CardContainer.vue";
import Tooltip from "@/components/Tooltip.vue";
import IconProfile from "@/components/icons/IconProfile.vue";

const props = defineProps<{
    password_reset_url: string;
    auth_login: string;
}>();

const form = useForm({
    email: "",
});

function submitForm() {
    form.post(props.password_reset_url);
}
</script>

<script lang="ts">
import App from "@/layouts/App.vue";
import { useForm } from "@inertiajs/vue3";
export default {
    layout: App,
};
</script>
