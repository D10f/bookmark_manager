<template>
    <CardContainer title="Export" collapsable>
        <div class="px-4 py-2">
            <div class="py-2">
                <p>Export bookmark data ready to be used by browsers.</p>
                <BaseButton class="my-2" @click="handleExportBookmark">Export</BaseButton>
            </div>
        </div>
    </CardContainer>
</template>

<script setup lang="ts">
import BaseButton from "@/components/BaseButton.vue";
import CardContainer from "@/components/CardContainer.vue";
import { BookmarkExporter } from "@/helpers/bookmarks";

const props = defineProps<{
    export_url: string;
}>();

async function handleExportBookmark() {
    const res = await fetch(props.export_url);
    const data = await res.json();
    const be = new BookmarkExporter(data);
    const bookmarksDoc = be.export();
    const bookmarksHtml =
        bookmarksDoc.head.outerHTML + bookmarksDoc.body.outerHTML;
    const blob = new Blob([bookmarksHtml], { type: "text/html" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "Bookmarks.html";
    a.click();
    a.remove();
    URL.revokeObjectURL(url);
}
</script>
