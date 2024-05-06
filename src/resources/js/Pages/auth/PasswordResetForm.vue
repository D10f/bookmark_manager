<template>
    <CardContainer title="Enter New Password" class="mt-2">
        <form class="px-4 py-2" @submit.prevent="submitForm">
            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Email" name="email" disabled v-model="form.email" :error="form.errors.email" />
            </div>

            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Password" type="text" name="password" autofocus v-model="form.password"
                    :error="form.errors.password" />
            </div>

            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Confirm Password" type="text" name="confirmPassword"
                    v-model="form.password_confirmation" :error="form.errors.password_confirmation" />
            </div>

            <input type="hidden" name="token" :value="token" />

            <div class="py-2">
                <BaseButton :loading="form.processing" class="mt-2" type="submit">
                    Reset Password
                    <template #loading> ... </template>
                </BaseButton>
            </div>
        </form>
    </CardContainer>
</template>

<script setup lang="ts">
import BaseInput from "@/components/BaseInput.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardContainer from "@/components/CardContainer.vue";

const props = defineProps<{
    password_update_url: string;
    email: string;
    token: string;
}>();

const form = useForm({
    email: props.email,
    password: "",
    password_confirmation: "",
});

function submitForm() {
    form.transform((data) => ({
        ...data,
        token: props.token,
    })).post(props.password_update_url);
}
</script>

<script lang="ts">
import App from "@/layouts/App.vue";
import { useForm } from "@inertiajs/vue3";
export default {
    layout: App,
};
</script>
