<template>
    <div>
        <Component v-for="link in links" :is="link.url ? 'Link' : 'span'" :href="link.url" v-html="link.label" class="px-1"
            :class="{
                'text-indigo-600 font-bold underline': link.active,
                'text-gray-500': !link.url,
            }" />

        <!-- <template v-for="link in users.links"> -->
        <!--     <Link v-html="link.label" :href="link.url" v-if="link.url" /> -->
        <!--     <span v-else v-html="link.label" /> -->
        <!-- </template> -->
    </div>
</template>

<script setup>
defineProps({
    links: Array,
});
</script>
