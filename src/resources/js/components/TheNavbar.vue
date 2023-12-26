<template>
    <header
        class="relative z-50 font-bold text-md text-white bg-slate-950 border-b border-b-slate-700 rounded-md shadow-y shadow-sm shadow-slate-900 p-4 flex justify-between items-center">
        <h3>Welcome back, {{ username }}</h3>

        <div class="flex gap-2 text-xl">
            <SearchBox />

            <!-- <BaseButton as="Link" href="#" intent="rounded" @click=""> -->
            <!--     <Tooltip tooltip="Settings" position="bottom"> -->
            <!--         <IconCog class="w-8 h-8 p-2" /> -->
            <!--     </Tooltip> -->
            <!-- </BaseButton> -->

            <BaseButton as="Link" :href="profileUrl" intent="rounded">
                <Tooltip tooltip="Account" position="bottom">
                    <IconProfile class="w-8 h-8 p-2" />
                </Tooltip>
            </BaseButton>
        </div>
    </header>
</template>

<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import IconProfile from "@/components/icons/IconProfile.vue";
import IconCog from "@/components/icons/IconCog.vue";
import Tooltip from "@/components/Tooltip.vue";
import BaseButton from "@/components/BaseButton.vue";
import SearchBox from "@/components/SearchBox.vue";

const page = usePage<App.Inertia.Middleware>();

const profileUrl = page.props.profile_url;
const username = page.props.auth?.user.name;
</script>
