import { createApp, h } from "vue";
import { Head, Link, createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createPinia } from "pinia";
import AppLayout from "@/layouts/App.vue";
import "../css/app.css";

const TITLE = "Bookmark Manager - ";

createInertiaApp({
    progress: {
        delay: 250,
        showSpinner: true,
    },

    title: (title) => TITLE + title,

    resolve: async (name) => {
        const page = await resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue"),
        );

        if (page.default.layout === undefined) {
            page.default.layout = AppLayout;
        }

        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(createPinia())
            .component("Link", Link)
            .component("Head", Head)
            .mount(el);
    },
});
