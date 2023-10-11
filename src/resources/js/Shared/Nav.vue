<script setup>
import NavLink from "./NavLink.vue";
</script>

<template>
    <nav>
        <ul class="flex justify-between items-center gap-4">
            <li>
                <NavLink href="/" :active="$page.component == 'Home'">
                    Home
                </NavLink>
            </li>
            <li>
                <NavLink href="/users" :active="$page.component == 'Users'">
                    Users
                </NavLink>
            </li>
            <li>
                <NavLink
                    href="/settings"
                    :active="$page.component == 'Settings'"
                >
                    Settings
                </NavLink>
            </li>
            <li>
                <NavLink
                    href="/logout"
                    method="post"
                    class="text-blue-600 hover:underline"
                >
                    Logout
                </NavLink>
            </li>
        </ul>
    </nav>
</template>
