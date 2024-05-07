<template>
    <ProfileUserOptions
        :user="user"
        :delete_confirmation="delete_confirmation"
        :update_url="update_url"
        :delete_url="delete_url"
        :logout_url="logout_url"
    />

    <!-- <CardContainer title="Appearance" collapsable> -->
    <!--     <!-1- TODO: -->
    <!--         Card container transparency control -->
    <!--         Black & white filter for favicons -->
    <!--         Toggle favicons -->
    <!--         Default folder favicon -->
    <!--         Default missing favicon -->
    <!--         Theme -->
    <!--         Background (color, image, blobs, etc) -->
    <!--     -1-> -->
    <!-- </CardContainer> -->

    <!-- <CardContainer title="Shortcuts" collapsable> -->
    <!--     <div class="px-4 py-2"> -->
    <!--         <div class="py-2"> -->
    <!--             <Keybind :keys="['ctrl', 'k']">Search for bookmarks.</Keybind> -->
    <!--             <Keybind :keys="['ctrl', 'p']">Open profile page.</Keybind> -->
    <!--             <Keybind :keys="['ctrl', 'b']">Create new bookmark.</Keybind> -->
    <!--         </div> -->
    <!--     </div> -->
    <!--     <!-1- TODO: -->
    <!--         Ctrl + K for search -->
    <!--         Ctrl + A to add new bookmark -->
    <!--         Ctrl + B to import / export -->
    <!--         Ctrl + 1 to launch <insert_url> -->
    <!--     -1-> -->
    <!-- </CardContainer> -->

    <ProfileImportOptions :import_url="import_url" />

    <ProfileExportOptions :export_url="export_url" />

    <ProfileKeyOptions />
</template>

<script setup lang="ts">
import CardContainer from "@/components/CardContainer.vue";
import Keybind from "@/components/Keybind.vue";
import ProfileUserOptions from "@/components/ProfileUserOptions.vue";
import ProfileImportOptions from "@/components/ProfileImportOptions.vue";
import ProfileExportOptions from "@/components/ProfileExportOptions.vue";
import ProfileKeyOptions from "@/components/ProfileKeyOptions.vue";

defineProps<{
    user: App.Models.User;
    delete_confirmation: string;
    update_url: string;
    delete_url: string;
    logout_url: string;
    import_url: string;
    export_url: string;
}>();
</script>

<script lang="ts">
import App from "@/layouts/App.vue";
import Page from "@/layouts/Page.vue";
export default {
    layout: [App, Page],
};
</script>
