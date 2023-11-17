<template>
    <!-- <aside class="flex justify-end items-center mt-2 z-10"> -->
    <!--     <ButtonLink to="#"> -->
    <!--         <IconProfile -->
    <!--             class="group-hover:fill-slate-950 fill-white w-4 h-4 mr-2" -->
    <!--         /> -->
    <!--         Don't have an account? -->
    <!--     </ButtonLink> -->
    <!-- </aside> -->
    <CardContainer title="Login">
        <template #actions>
            <Link :href="auth_register">
                <Tooltip tooltip="Don't have an account?">
                    <IconProfile
                        class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
                    />
                </Tooltip>
            </Link>
        </template>
        <form class="px-4 py-2" @submit.prevent="submitForm">
            <div class="py-2 flex flex-col gap-1">
                <BaseInput
                    label="Email"
                    v-model="form.email"
                    autofocus
                    :error="form.errors.email"
                />
            </div>

            <div class="py-2 flex flex-col gap-1">
                <BaseInput
                    label="Password"
                    type="password"
                    v-model="form.password"
                    :error="form.errors.password"
                />
            </div>

            <div class="py-2">
                <BaseButton
                    :loading="form.processing"
                    class="mt-2"
                    type="submit"
                >
                    Login
                    <template #loading> ... </template>
                </BaseButton>
            </div>
        </form>
    </CardContainer>
</template>

<script setup lang="ts">
import Site from "@/layouts/Site.vue";
import BaseInput from "@/components/BaseInput.vue";
import BaseButton from "@/components/BaseButton.vue";
import Tooltip from "@/components/Tooltip.vue";
import CardContainer from "@/components/CardContainer.vue";
import IconProfile from "@/components/icons/IconProfile.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps<{ auth_register: string; auth_login: string }>();

const form = useForm({
    email: "",
    password: "",
});

function submitForm() {
    form.post(props.auth_login);
}
</script>

<script lang="ts">
export default {
    layout: Site,
};
</script>
