<template>
    <!-- <Head> -->
    <!--     <meta -->
    <!--         name="description" -->
    <!--         head-key="description" -->
    <!--         content="A modern bookmark manager for the DIY enthusiasts." -->
    <!--     /> -->
    <!-- </Head> -->
    <div class="bg-slate-700 text-white min-h-screen p-1">
        <TheNavbar />

        <main class="flex flex-col gap-2 z-50">
            <slot />
        </main>

        <div class="fixed blur-xl w-96 h-24 bg-cyan-500 top-1/4 left-1/3 rounded-full" />

        <div class="fixed blur-xl w-32 h-32 bg-purple-800 bottom-64 left-48 rounded-full" />

        <div class="fixed blur-xl w-32 h-32 bg-fuchsia-400 bottom-24 left-12 rounded-full" />

        <div class="fixed blur-xl w-64 h-64 bg-pink-500 bottom-24 left-10 rounded-full" />
    </div>
</template>

<script setup lang="ts">
// import Head from "@inertiajs/vue3";
import TheNavbar from "@/components/TheNavbar.vue";
</script>
