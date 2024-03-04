<template>
    <!-- <aside class="flex justify-end items-center mt-2 z-10"> -->
    <!--     <ButtonLink to="#"> -->
    <!--         <IconProfile -->
    <!--             class="group-hover:fill-slate-950 fill-white w-4 h-4 mr-2" -->
    <!--         /> -->
    <!--         Don't have an account? -->
    <!--     </ButtonLink> -->
    <!-- </aside> -->
    <CardContainer title="Register New Account" class="mt-2">
        <template #actions>
            <Link :href="auth_login">
            <Tooltip tooltip="Already have an account?" position="bottom">
                <IconProfile class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full" />
            </Tooltip>
            </Link>
        </template>
        <form class="px-4 py-2" @submit.prevent="submitForm">
            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Email" name="email" autofocus v-model="form.email" :error="form.errors.email" />
            </div>

            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Password" type="text" name="password" v-model="form.password"
                    :error="form.errors.password" />
            </div>

            <div class="py-2 flex flex-col gap-1">
                <BaseInput label="Confirm Password" type="text" name="confirmPassword" v-model="form.password_confirmation"
                    :error="form.errors.password_confirmation" />
            </div>

            <div class="py-2">
                <BaseButton :loading="form.processing" class="mt-2" type="submit">
                    Sign Up
                    <template #loading> ... </template>
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
import { useForm } from "@inertiajs/vue3";

const props = defineProps<{ auth_login: string; auth_store: string }>();

const form = useForm({
    email: "",
    password: "",
    password_confirmation: "",
});

function submitForm() {
    form.post(props.auth_store);
}
</script>

<script lang="ts">
export default {
    layout: App,
};
</script>
