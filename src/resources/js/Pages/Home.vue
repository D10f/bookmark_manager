<script setup lang="ts">
import IconPlus from "@/Shared/IconPlus.vue";
import Modal from "@/Shared/Modal.vue";
import BookmarkContainer from "@/Shared/BookmarkContainer.vue";
import BookmarkItem from "@/Shared/BookmarkItem.vue";
import TheNavbar from "@/Shared/TheNavbar.vue";
import { ref } from "vue";

const entertainmentBookmarks: any[] = [
    {
        key: Math.random(),
        url: "https://odysee.com",
        name: "Odysee",
    },
    {
        key: Math.random(),
        url: "https://nebula.com",
        name: "Nebula",
    },
    {
        key: Math.random(),
        url: "https://nebula.com",
        name: "PeerTube",
    },
    {
        key: Math.random(),
        name: "test",
    },
];

const searchEngineBookmarks: any[] = [
    {
        url: "https://mojeek.com",
        name: "Mojeek",
    },
    {
        url: "https://qwant.com",
        name: "Qwant",
    },
];

let showModal = ref(false);
</script>

<template>
    <main class="flex flex-col gap-2 bg-slate-700 text-white min-h-screen p-1">
        <TheNavbar />

        <BookmarkContainer title="Entertainment">
            <BookmarkItem
                v-for="bookmark in entertainmentBookmarks"
                :bookmark="bookmark"
                :key="bookmark.key"
            />
            <!-- <template v-for="bookmark in entertainmentBookmarks" :key="bookmark.key"> -->
            <!-- </template> -->
        </BookmarkContainer>

        <BookmarkContainer title="Search">
            <template
                v-for="bookmark in searchEngineBookmarks"
                :key="bookmark.key"
            >
                <BookmarkItem :bookmark="bookmark" />
            </template>
        </BookmarkContainer>
    </main>

    <Modal :show="showModal" @closeModal="showModal = false">
        <template #header>
            <h3>Create New Bookmark</h3>
        </template>

        <template #default>
            <form @submit.prevent>
                <article class="py-2">
                    <label for="category" class="text-md"> Category: </label>
                    <input
                        id="category"
                        name="category"
                        class="rounded-sm w-full p-1 text-slate-900 focus:outline-0"
                        type="text"
                        placeholder="Enter category"
                    />
                </article>
                <article class="py-2">
                    <label for="title" class="text-md"> Title: </label>
                    <input
                        id="title"
                        name="title"
                        class="rounded-sm w-full p-1 text-slate-900"
                        type="text"
                        placeholder="Enter title"
                    />
                </article>
                <article class="py-2">
                    <label for="url" class="text-md"> URL: </label>
                    <input
                        id="url"
                        name="url"
                        class="rounded-sm w-full p-1 text-slate-900"
                        type="text"
                        placeholder="Enter URL"
                    />
                </article>
            </form>
        </template>

        <template #footer>
            <button
                @click="$emit('submitModal')"
                class="text-right p-2 rounded-sm text-slate-900 bg-amber-400 hover:bg-amber-600 focus:bg-amber-600"
            >
                Submit
            </button>
        </template>
    </Modal>

    <aside class="fixed bottom-8 right-8">
        <button
            class="w-12 h-12 rounded-full bg-slate-100 text-xl"
            @click="showModal = true"
        >
            <IconPlus class="fill-slate-700" />
        </button>
    </aside>

    <div
        class="absolute blur-xl w-96 h-24 bg-cyan-500 top-1/4 left-1/3 rounded-full animate-[spin_200s_linear_infinite]"
    />

    <div
        class="absolute blur-2xl w-64 h-64 bg-pink-500 bottom-24 left-10 rounded-full animate-[pulse_40s_linear_infinite]"
    />
</template>
