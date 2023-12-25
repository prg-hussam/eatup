import "./bootstrap";
import Toast from "vue-toastification";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import BootstrapVue3 from "bootstrap-vue-3";
import vClickOutside from "click-outside-vue3";
import VueSweetalert2 from "vue-sweetalert2";
import { tooltip } from "./Core/tooltip";
import { popover } from "./Core/popover";
import { i18nVue } from "laravel-vue-i18n";

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Platform";

const sweetalertOptions = {
    buttonsStyling: false,
    confirmButtonClass: "btn btn-primary me-2 w-xs mt-2",
    cancelButtonClass: "btn btn-danger w-xs mt-2",
};
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },

    progress: {
        color: "#4B5563",
    },
    setup({ el, App, props, plugin }) {
        createApp({
            render: () => h(App, props),
        })
            .use(i18nVue, {
                lang: Platform.locale,
                fallbackLocale: Platform.fallbackLocale,
                resolve: async (lang) => {
                    const langs = import.meta.glob("../../lang/*.json");
                    if (lang.includes("php_")) {
                        return await langs[`../../lang/${lang}.json`]();
                    }
                },
            })
            .use(Toast)
            .use(plugin)
            .use(VueSweetalert2, sweetalertOptions)
            .use(BootstrapVue3)
            .use(ZiggyVue, Ziggy)
            .use(vClickOutside)
            .directive("tooltip", tooltip)
            .directive("popover", popover)
            .mount(el);
    },
});
