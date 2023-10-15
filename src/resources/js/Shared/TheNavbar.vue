<template>
    <header
        class="z-10 font-bold text-md bg-slate-950 border-b border-b-slate-700 rounded-md shadow-y shadow-sm shadow-slate-900 p-4 flex justify-between items-center"
    >
        <h2>Welcome back, Test User!</h2>

        <div class="flex gap-3 text-xl">
            <button
                class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
            >
                <IconSearch />
            </button>
            <button
                class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
            >
                <IconCog />
            </button>
            <button
                class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
            >
                <IconProfile />
            </button>
        </div>
    </header>
</template>

<script setup lang="ts">
import IconProfile from "@/Shared/IconProfile.vue";
import IconSearch from "@/Shared/IconSearch.vue";
import IconCog from "@/Shared/IconCog.vue";
</script>
