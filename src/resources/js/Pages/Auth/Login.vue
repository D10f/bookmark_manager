<template>
    <Head title="Login User" />

    <main class="grid place-items-center min-h-screen">
        <section class="max-w-md mx-auto border rounded p-8">
            <h1 class="text-3xl">Login</h1>

            <form @submit.prevent="submit" class="mt-6">
                <div class="mb-6">
                    <label
                        for="email"
                        class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        >Email</label
                    >

                    <input
                        v-model="form.email"
                        autofocus
                        class="border border-gray-400 rounded p-2 w-full"
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
                        class="border border-gray-400 rounded p-2 w-full"
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
        </section>
    </main>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

let form = useForm({
    email: "",
    password: "",
});

let submit = () => {
    form.post("/login", form);
};
</script>

<script>
export default {
    layout: null,
};
</script>
