<template>
    <Head>
        <meta
            name="description"
            head-key="description"
            content="A modern bookmark manager for the DIY enthusiasts."
        />
    </Head>
    <header class="flex items-center p-4 gap-2 bg-gray-200">
        <h1 class="text-2xl">My App</h1>
        <p>Welcome back, {{ username }}!</p>
        <Nav class="ml-auto" />
    </header>

    <main class="max-w-4xl mx-auto my-4">
        <slot />
    </main>
</template>

<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import Nav from "@/Shared/Nav.vue";

const page = usePage();

const username = computed(() => {
    return page.props.auth.user.username;
});
</script>
