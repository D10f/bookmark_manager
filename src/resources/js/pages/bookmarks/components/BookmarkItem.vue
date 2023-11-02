<template>
    <li
        class="group/item flex justify-between items-center gap-2 rounded-md py-1"
    >
        <BookmarkFavicon :bookmark="bookmark" />

        <a
            class="inline-block text-lg w-full h-full hover:text-yellow-500"
            :tabIndex="isCollapsed ? -1 : 0"
            :href="bookmark.url ?? '#'"
            target="_blank"
            >{{ bookmark.name }}</a
        >
        <Link :href="editUrl">
            <IconPencil
                class="flex justify-center items-center w-10 h-8 hover:bg-slate-600 p-2 rounded-full"
            />
        </Link>

        <!-- <button -->
        <!--     class="group/edit md:invisible md:group-hover/item:visible rounded-full hover:bg-slate-600 h-8 w-9 p-2" -->
        <!--     :tabIndex="isCollapsed ? -1 : 0" -->
        <!--     @click="$emit('showEditModal', bookmark)" -->
        <!-- > -->
        <!--     <IconPencil class="group-hover/edit:fill-yellow-500" /> -->
        <!-- </button> -->
    </li>
</template>

<script setup lang="ts">
import IconPencil from "@/shared/components/icons/IconPencil.vue";
import BookmarkFavicon from "@/pages/bookmarks/components/BookmarkFavicon.vue";
// import ButtonLink from "@/shared/components/ButtonLink.vue";
import { Bookmark } from "@/models/Bookmark";
import { inject, ref } from "vue";

const props = defineProps<{ bookmark: Bookmark }>();
const isCollapsed = inject("isCollapsed");

const editUrl = ref(`/app/bookmarks/${props.bookmark.id}/edit`);
</script>

<style>
svg {
    max-width: 100%;
    max-height: 100%;
}
</style>
