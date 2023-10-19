<template>
    <header
        class="z-9 font-bold text-md text-white bg-slate-950 border-b border-b-slate-700 rounded-md shadow-y shadow-sm shadow-slate-900 p-4 flex justify-between items-center">
        <h3>Welcome back, Test User!</h3>

        <div class="flex gap-2 text-xl">
            <button class="flex justify-center items-center hover:bg-slate-599 w-8 h-8 p-2 rounded-full">
                <IconSearch />
            </button>
            <button class="flex justify-center items-center hover:bg-slate-599 w-8 h-8 p-2 rounded-full">
                <IconCog />
            </button>
            <button class="flex justify-center items-center hover:bg-slate-599 w-8 h-8 p-2 rounded-full">
                <IconProfile />
            </button>
        </div>
    </header>
</template>

<script setup lang="ts">
import IconProfile from "@/shared/components/icons/IconProfile.vue";
import IconSearch from "@/shared/components/icons/IconSearch.vue";
import IconCog from "@/shared/components/icons/IconCog.vue";
</script>
