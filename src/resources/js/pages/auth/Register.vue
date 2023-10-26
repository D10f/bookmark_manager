<template>
    <!-- <aside class="flex justify-end items-center mt-2 z-10"> -->
    <!--     <ButtonLink to="#"> -->
    <!--         <IconProfile -->
    <!--             class="group-hover:fill-slate-950 fill-white w-4 h-4 mr-2" -->
    <!--         /> -->
    <!--         Don't have an account? -->
    <!--     </ButtonLink> -->
    <!-- </aside> -->
    <CardContainer title="Register New Account">
        <template #actions>
            <Link :href="auth_login">
                <Tooltip tooltip="Already have an account?">
                    <IconProfile
                        class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
                    />
                </Tooltip>
            </Link>
        </template>
        <form class="px-4 py-2" @submit.prevent="submitForm">
            <BaseInput
                label="Email"
                name="email"
                v-model="form.email"
                :error="form.errors.email"
            />

            <BaseInput
                label="Password"
                type="text"
                name="password"
                v-model="form.password"
                :error="form.errors.password"
            />

            <BaseInput
                label="Confirm Password"
                type="text"
                name="confirmPassword"
                v-model="form.password_confirmation"
                :error="form.errors.password_confirmation"
            />

            <BaseButton :loading="form.processing" class="mt-2" type="submit">
                Sign Up
                <template #loading> ... </template>
            </BaseButton>
        </form>
    </CardContainer>
</template>

<script setup lang="ts">
import Site from "@/shared/layouts/Site.vue";
import BaseInput from "@/shared/components/forms/BaseInput.vue";
import BaseButton from "@/shared/components/BaseButton.vue";
import Tooltip from "@/shared/components/Tooltip.vue";
import CardContainer from "@/shared/components/CardContainer.vue";
import IconProfile from "@/shared/components/icons/IconProfile.vue";
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
    layout: Site,
};
</script>
