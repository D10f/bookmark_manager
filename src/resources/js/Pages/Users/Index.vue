<template>
    <Head title="Users" />

    <header class="flex justify-between items-center mb-6">
        <div>
            <h2 class="font-bold text-2xl inline">Users</h2>

            <Link
                v-if="can.createUser"
                href="/users/create"
                class="mx-4 inline text-blue-500"
                >New User</Link
            >
        </div>

        <label>
            <input
                v-model="search"
                class="border-gray-400 border rounded px-2"
                placeholder="Search"
            />
        </label>
    </header>

    <table class="min-w-full">
        <tbody class="divide-y divide-gray-200">
            <tr v-for="user in users.data" :key="user.id">
                <td class="px-6 py-4 whitespace-nowrap">
                    <h3>{{ user.name }}</h3>
                </td>
                <td
                    class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                >
                    <Link
                        v-if="user.can.edit"
                        :href="`/users/${user.id}/edit`"
                        class="text-indigo-600 hover:text-indigo-900"
                    >
                        Edit</Link
                    >
                </td>
            </tr>
        </tbody>
    </table>

    <Pagination :links="users.links" class="mt-6" />
</template>

<script setup>
import Pagination from "@/Shared/Pagination.vue";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash";

const props = defineProps({
    users: Object,
    filters: Object,
    can: Object,
});

let search = ref(props.filters.search);

watch(
    search,
    debounce((value) => {
        router.get(
            "/users",
            { search: value },
            { preserveState: true, replace: true },
        );
    }, 500),
);
</script>
