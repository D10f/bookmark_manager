<script setup>
import IconProfile from "@/Shared/IconProfile.vue";
import IconSearch from "@/Shared/IconSearch.vue";
import IconChevron from "@/Shared/IconChevron.vue";
import IconCog from "@/Shared/IconCog.vue";
import IconPlus from "@/Shared/IconPlus.vue";
import IconPencil from "@/Shared/IconPencil.vue";
</script>

<template>
    <main class="flex flex-col gap-2 bg-slate-700 text-white min-h-screen p-1">
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

        <section
            class="z-10 bg-slate-900 bg-opacity-80 border-b border-b-slate-700 rounded-md shadow-y shadow-sm shadow-slate-900"
        >
            <header
                class="group flex justify-between items-center bg-slate-950 font-bold text-md rounded-t-md p-3"
            >
                <h3>Productivity</h3>

                <div
                    class="opacity-25 group-hover:opacity-100 flex gap-3 text-xl"
                >
                    <button
                        class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
                    >
                        <IconCog />
                    </button>
                    <button
                        class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
                    >
                        <IconChevron />
                    </button>
                </div>
            </header>

            <div class="p-4">
                <ul class="grid grid-cols-2 gap-4">
                    <li class="h-24 bg-slate-600 hover:bg-slate-700">
                        <a class="inline-block w-full h-full" href="">One</a>
                    </li>
                    <li class="h-24 bg-slate-600 hover:bg-slate-700">
                        <a class="inline-block w-full h-full" href="">Two</a>
                    </li>
                    <li class="h-24 bg-slate-600 hover:bg-slate-700">
                        <a class="inline-block w-full h-full" href="">Three</a>
                    </li>
                </ul>
            </div>
        </section>

        <section
            class="z-10 bg-slate-900 bg-opacity-80 border-b border-b-slate-700 rounded-md shadow-y shadow-sm shadow-slate-900"
        >
            <header
                class="group flex justify-between items-center bg-slate-950 font-bold text-md rounded-t-md p-3"
            >
                <h3>Entertainment</h3>
                <div
                    class="opacity-25 group-hover:opacity-100 flex gap-3 text-xl"
                >
                    <button
                        class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
                    >
                        <IconCog />
                    </button>
                    <button
                        class="flex justify-center items-center hover:bg-slate-600 w-8 h-8 p-2 rounded-full"
                    >
                        <IconChevron />
                    </button>
                </div>
            </header>

            <div class="p-4">
                <ul class="grid grid-cols-2 gap-4">
                    <li class="h-24 bg-slate-600 hover:bg-slate-700">
                        <a class="inline-block w-full h-full" href="">One</a>
                    </li>
                    <li class="h-24 bg-slate-600 hover:bg-slate-700">
                        <a class="inline-block w-full h-full" href="">Two</a>
                    </li>
                    <li class="h-24 bg-slate-600 hover:bg-slate-700">
                        <a class="inline-block w-full h-full" href="">Three</a>
                    </li>
                </ul>
            </div>
        </section>
    </main>

    <aside class="fixed bottom-8 right-8">
        <button class="w-12 h-12 rounded-full bg-slate-100 text-xl">
            &plus;
        </button>
    </aside>

    <div
        class="absolute blur-xl w-96 h-24 bg-cyan-500 top-1/4 left-1/3 rounded-full animate-[spin_200s_linear_infinite]"
    />

    <div
        class="absolute blur-xl w-64 h-64 bg-pink-500 bottom-24 left-10 rounded-full animate-[pulse_40s_linear_infinite]"
    />
</template>
