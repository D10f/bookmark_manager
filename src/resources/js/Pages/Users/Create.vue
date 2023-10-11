<template>
    <Head title="Create User" />

    <h1 class="text-3xl">Create New User</h1>

    <form @submit.prevent="submit" class="max-w-md mx-auto mt-8">
        <div class="mb-6">
            <label
                for="name"
                class="block mb-2 uppercase font-bold text-xs text-gray-700"
            >
                Name
            </label>

            <input
                v-model="form.name"
                class="border border-gray-400 p-2 w-full"
                id="name"
                type="text"
                name="name"
            />
            <span
                v-if="form.errors.name"
                v-text="form.errors.name"
                class="text-red-600 text-xs mt-1"
            />
        </div>

        <div class="mb-6">
            <label
                for="email"
                class="block mb-2 uppercase font-bold text-xs text-gray-700"
                >Email</label
            >

            <input
                v-model="form.email"
                class="border border-gray-400 p-2 w-full"
                id="email"
                type="text"
                name="email"
            />
            <span
                v-if="form.errors.email"
                v-text="form.errors.email"
                class="text-red-600 text-xs mt-1"
            />
        </div>

        <div class="mb-6">
            <label
                for="password"
                class="block mb-2 uppercase font-bold text-xs text-gray-700"
                >Password</label
            >

            <input
                v-model="form.password"
                class="border border-gray-400 p-2 w-full"
                id="password"
                type="password"
                name="password"
            />
            <span
                v-if="$page.props.errors.password"
                v-text="$page.props.errors.password"
                class="text-red-600 text-xs mt-1"
            />
        </div>

        <div class="mb-6">
            <button
                type="submit"
                class="bg-blue-500 text-white rounded py-2 px-4 hover:bg-blue-400"
                :class="{
                    'bg-gray-400 text-gray-800 hover:bg-gray-400 cursor-not-allowed':
                        form.processing,
                }"
                :disabled="form.processing"
            >
                Submit
            </button>
        </div>
    </form>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

let form = useForm({
    name: "",
    email: "",
    password: "",
});

let submit = () => {
    form.post("/users", form);
};
</script>
