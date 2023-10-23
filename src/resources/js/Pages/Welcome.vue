<template>
    <header class="mt-10 text-center">
        <h1 class="text-6xl font-extrabold">Bookmark Manager</h1>
        <p class="text-lg font-bold my-8">For the DIY enthusiasts</p>
        <BaseButton class="mx-auto">Try It Out!</BaseButton>
    </header>

    <CardContainer collapsable title="Features" class="mt-8 mb-4">
        <div>
            <ul>
                <li>
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing
                        elit. Autem, nihil.
                    </p>
                </li>
                <li>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                </li>
            </ul>
        </div>
    </CardContainer>

    <CardContainer title="Features" class="mt-8 mb-4">
        <div class="p-2">
            <ul>
                <li>
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing
                        elit. Autem, nihil.
                    </p>
                </li>
                <li>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                </li>
            </ul>
        </div>
    </CardContainer>

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
import BaseButton from "@/shared/components/BaseButton.vue";
import CardContainer from "@/shared/components/CardContainer.vue";
</script>

<script lang="ts">
import Site from "@/shared/Layouts/Site.vue";

export default {
    layout: Site,
};
</script>
