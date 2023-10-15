<script setup lang="ts">
import IconPlus from "@/Shared/IconPlus.vue";
import BookmarkBox from "@/Shared/BookmarkBox.vue";
import TheNavbar from "@/Shared/TheNavbar.vue";

const entertainmentBookmarks: any[] = [
    {
        url: "https://odysee.com",
        name: "Odysee",
    },
    {
        url: "https://nebula.com",
        name: "Nebula",
    },
    {
        name: "PeerTube",
    },
];
</script>

<template>
    <main class="flex flex-col gap-2 bg-slate-700 text-white min-h-screen p-1">
        <TheNavbar />
        <BookmarkBox title="Entertainment" :bookmarks="entertainmentBookmarks" />
        <BookmarkBox title="Productivity" :bookmarks="[]" />
        <BookmarkBox title="Videos" :bookmarks="[]" />
    </main>

    <aside class="fixed bottom-8 right-8">
        <button class="w-12 h-12 rounded-full bg-slate-100 text-xl">
            <IconPlus />
        </button>
    </aside>

    <div class="absolute blur-xl w-96 h-24 bg-cyan-500 top-1/4 left-1/3 rounded-full animate-[spin_200s_linear_infinite]" />

    <div class="absolute ur-xl w-64 h-64 bg-pink-500 bottom-24 left-10 rounded-full animate-[pulse_40s_linear_infinite]" />
</template>
