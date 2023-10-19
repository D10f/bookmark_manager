<template>
    <!-- <Head> -->
    <!--     <meta -->
    <!--         name="description" -->
    <!--         head-key="description" -->
    <!--         content="A modern bookmark manager for the DIY enthusiasts." -->
    <!--     /> -->
    <!-- </Head> -->
    <!-- <header -->
    <!--     class="text-white z-9 font-bold text-md bg-slate-950 border-b border-b-slate-700 rounded-md shadow-y shadow-sm shadow-slate-900 p-4 flex justify-between items-center"> -->
    <!--     <h3>Welcome back, Test User!</h3> -->

    <!--     <div class="flex gap-2 text-xl"> -->
    <!--         <button class="flex justify-center items-center hover:bg-slate-599 w-8 h-8 p-2 rounded-full"> -->
    <!--             <IconSearch /> -->
    <!--         </button> -->
    <!--         <button class="flex justify-center items-center hover:bg-slate-599 w-8 h-8 p-2 rounded-full"> -->
    <!--             <IconCog /> -->
    <!--         </button> -->
    <!--         <button class="flex justify-center items-center hover:bg-slate-599 w-8 h-8 p-2 rounded-full"> -->
    <!--             <IconProfile /> -->
    <!--         </button> -->
    <!--     </div> -->
    <!-- </header> -->
    <div class="bg-slate-700 text-white min-h-screen p-1">
        <TheNavbar />

        <main class="flex flex-col gap-2">
            <slot />
        </main>

        <div
            class="absolute blur-xl w-96 h-24 bg-cyan-500 top-1/4 left-1/3 rounded-full animate-[spin_200s_linear_infinite]" />

        <div
            class="absolute blur-xl w-32 h-32 bg-purple-800 bottom-64 left-48 rounded-full animate-[pulse_30s_linear_infinite]" />

        <div
            class="absolute blur-xl w-32 h-32 bg-fuchsia-400 bottom-24 left-12 rounded-full animate-[pulse_30s_linear_infinite]" />

        <div
            class="absolute blur-xl w-64 h-64 bg-pink-500 bottom-24 left-10 rounded-full animate-[pulse_40s_linear_infinite]" />
    </div>
</template>

<script setup lang="ts">
import IconProfile from "@/shared/components/icons/IconProfile.vue";
import IconSearch from "@/shared/components/icons/IconSearch.vue";
import IconCog from "@/shared/components/icons/IconCog.vue";
import Head from "@inertiajs/vue3";
import TheNavbar from "../components/TheNavbar.vue";
</script>
