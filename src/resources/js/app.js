import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createPinia } from "pinia";
import AppLayout from "@/shared/Layouts/App.vue";
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
            .mount(el);
    },
});
