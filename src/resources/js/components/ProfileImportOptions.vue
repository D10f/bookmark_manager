<template>
    <CardContainer title="Import" collapsable>
        <div class="px-4 py-2">
            <div class="py-2">
                <p>
                    Import bookmarks from another browser backup. Supported
                    formats: HTML.
                </p>
                <input type="file" class="invisible w-0 h-0" aria-hidden ref="htmlImport" @change="handleFilePicker" />
                <BaseButton class="my-2" @click="() => htmlImport.click()">Import</BaseButton>
            </div>
        </div>
    </CardContainer>
</template>

<script setup lang="ts">
import BaseButton from "@/components/BaseButton.vue";
import CardContainer from "@/components/CardContainer.vue";
import { BookmarkParser } from "@/helpers/bookmarks";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps<{
    import_url: string;
}>();

const htmlImport = ref(null);
const importForm = useForm({});

async function handleFilePicker(event: Event) {
    const target = event.target as HTMLInputElement;
    const file = target.files![0];

    if (file.size > 5_000_000) {
        console.log("File size cannot exceed 5MB.");
        return;
    }

    if (file.type != "text/html") {
        console.log("Invalid file type: only HTML files are supported.");
        return;
    }

    try {
        const bp = new BookmarkParser();
        const bookmarks = await bp.parse(file);
        importForm
            .transform(() => ({ data: bookmarks }))
            .post(props.import_url);
    } catch (e) {
        console.log((e as Error).message);
    }
}
</script>
