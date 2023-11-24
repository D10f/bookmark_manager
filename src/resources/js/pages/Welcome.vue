<template>
    <header class="mt-10 text-center">
        <h1 class="text-6xl font-extrabold">Bookmark Manager</h1>
        <p class="text-lg font-bold my-8">For the DIY enthusiasts</p>
        <BaseButton :as="Link" :href="bookmarks_index">Try it out!</BaseButton>
    </header>

    <div>
        <CardContainer collapsable title="Open Source" class="mt-8 mb-4">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Exercitationem voluptatibus earum, doloribus aperiam sapiente,
                repudiandae cum, possimus quis iste incidunt autem adipisci
                culpa non sed.
            </p>
        </CardContainer>
        <CardContainer collapsable title="Full Text Search" class="mt-8 mb-4">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Exercitationem voluptatibus earum, doloribus aperiam sapiente,
                repudiandae cum, possimus quis iste incidunt autem adipisci
                culpa non sed.
            </p>
        </CardContainer>
        <CardContainer collapsable title="Privacy Friendly" class="mt-8 mb-4">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Exercitationem voluptatibus earum, doloribus aperiam sapiente,
                repudiandae cum, possimus quis iste incidunt autem adipisci
                culpa non sed.
            </p>
        </CardContainer>
        <CardContainer collapsable title="Self Hostable" class="mt-8 mb-4">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Exercitationem voluptatibus earum, doloribus aperiam sapiente,
                repudiandae cum, possimus quis iste incidunt autem adipisci
                culpa non sed.
            </p>
        </CardContainer>
    </div>

    <footer class="bg-slate-900/60 rounded-md p-2 mt-4">
        <ul class="flex justify-evenly items-center">
            <li>
                <a href="#">Contact</a>
            </li>
            <li>
                <a href="#">FAQ</a>
            </li>
            <li>
                <a href="#">About</a>
            </li>
        </ul>
    </footer>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import BaseButton from "@/components/BaseButton.vue";
import CardContainer from "@/components/CardContainer.vue";
defineProps<{ bookmarks_index: string }>();
</script>

<script lang="ts">
import Site from "@/layouts/Site.vue";

export default {
    layout: Site,
};
</script>
